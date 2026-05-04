#include <WiFi.h>
#include <HTTPClient.h>
#include <Wire.h>
#include <Adafruit_PN532.h>
#include <Servo.h>

// Ganti dengan nama jaringan WiFi dan password Anda
const char* WIFI_SSID = "YOUR_SSID";
const char* WIFI_PASSWORD = "YOUR_PASSWORD";

// Ganti dengan alamat IP / domain Laravel Anda
const char* SERVER_BASE = "http://192.168.1.100:8000";

// Ganti dengan alamat IP ESP32-CAM Anda
const char* CAMERA_BASE = "http://192.168.1.101";

// Pin ESP32 untuk PN532 I2C
#define PN532_SDA 14
#define PN532_SCL 15
#define PN532_IRQ 4
#define PN532_RESET 2
Adafruit_PN532 nfc(PN532_IRQ, PN532_RESET);

// Pin servo dan LED indikator
const int SERVO_PIN = 12;
const int LED_GREEN_PIN = 13;
const int LED_RED_PIN = 16;

Servo gateServo;

// Sudut servo untuk buka / tutup palang
const int SERVO_CLOSED_ANGLE = 0;
const int SERVO_OPEN_ANGLE = 80;

void setup() {
  Serial.begin(115200);
  pinMode(LED_GREEN_PIN, OUTPUT);
  pinMode(LED_RED_PIN, OUTPUT);
  digitalWrite(LED_GREEN_PIN, LOW);
  digitalWrite(LED_RED_PIN, LOW);

  gateServo.attach(SERVO_PIN);
  gateServo.write(SERVO_CLOSED_ANGLE);

  Wire.begin(PN532_SDA, PN532_SCL);

  nfc.begin();
  uint32_t versiondata = nfc.getFirmwareVersion();
  if (!versiondata) {
    Serial.println("Tidak menemukan PN532, periksa koneksi.");
    while (true) {
      delay(1000);
    }
  }

  nfc.SAMConfig();
  Serial.println("PN532 siap.");
  nfc.setPassiveActivationRetries(0xFF);

  connectWiFi();
}

void loop() {
  Serial.println("Menunggu kartu NFC...");
  boolean success;
  uint8_t uid[7];
  uint8_t uidLength;

  success = nfc.readPassiveTargetID(PN532_MIFARE_ISO14443A, uid, &uidLength, 1000);
  if (!success) {
    delay(200);
    return;
  }

  String uidString = uidToString(uid, uidLength);
  Serial.print("UID NFC terbaca: ");
  Serial.println(uidString);

  bool allowed = checkAccess(uidString);
  triggerCameraCapture(uidString, allowed ? "allowed" : "denied");

  if (allowed) {
    Serial.println("Akses DIIZINKAN");
    setAccessLed(true);
    openGate();
    delay(4000);
    closeGate();
  } else {
    Serial.println("Akses DITOLAK");
    setAccessLed(false);
    delay(3000);
    turnOffLeds();
  }

  delay(1500);
}

void connectWiFi() {
  Serial.printf("Menghubungkan WiFi: %s\n", WIFI_SSID);
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  unsigned long start = millis();
  while (WiFi.status() != WL_CONNECTED && millis() - start < 20000) {
    Serial.print(".");
    delay(500);
  }
  Serial.println();
  if (WiFi.status() == WL_CONNECTED) {
    Serial.print("WiFi terhubung, IP: ");
    Serial.println(WiFi.localIP());
  } else {
    Serial.println("Gagal terhubung ke WiFi");
  }
}

String uidToString(uint8_t *uid, uint8_t length) {
  String uidStr = "";
  for (uint8_t i = 0; i < length; i++) {
    if (uid[i] < 0x10) uidStr += "0";
    uidStr += String(uid[i], HEX);
  }
  uidStr.toUpperCase();
  return uidStr;
}

bool checkAccess(const String &nfcUid) {
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
    if (WiFi.status() != WL_CONNECTED) return false;
  }

  HTTPClient http;
  String url = String(SERVER_BASE) + "/api/check-access";
  http.begin(url);
  http.addHeader("Content-Type", "application/json");

  String body = "{\"nfc_uid\":\"" + nfcUid + "\"}";
  int httpCode = http.POST(body);
  if (httpCode == 200) {
    String resp = http.getString();
    http.end();
    if (resp.indexOf("\"status\":\"allowed\"") >= 0) {
      return true;
    }
  } else {
    Serial.printf("checkAccess gagal, HTTP code: %d\n", httpCode);
  }
  http.end();
  return false;
}

void triggerCameraCapture(const String &nfcUid, const String &accessStatus) {
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
    if (WiFi.status() != WL_CONNECTED) {
      Serial.println("Tidak dapat memicu kamera karena WiFi tidak terhubung.");
      return;
    }
  }

  HTTPClient http;
  String url = String(CAMERA_BASE) + "/capture?nfc_uid=" + nfcUid + "&status=" + accessStatus;
  Serial.printf("Memicu ESP32-CAM: %s\n", url.c_str());
  http.begin(url);
  int httpCode = http.GET();
  if (httpCode == 200) {
    Serial.println("Trigger kamera berhasil.");
    Serial.println(http.getString());
  } else {
    Serial.printf("Trigger kamera gagal, HTTP code: %d\n", httpCode);
  }
  http.end();
}

void openGate() {
  gateServo.write(SERVO_OPEN_ANGLE);
}

void closeGate() {
  gateServo.write(SERVO_CLOSED_ANGLE);
}

void setAccessLed(bool allowed) {
  if (allowed) {
    digitalWrite(LED_GREEN_PIN, HIGH);
    digitalWrite(LED_RED_PIN, LOW);
  } else {
    digitalWrite(LED_GREEN_PIN, LOW);
    digitalWrite(LED_RED_PIN, HIGH);
  }
}

void turnOffLeds() {
  digitalWrite(LED_GREEN_PIN, LOW);
  digitalWrite(LED_RED_PIN, LOW);
}
