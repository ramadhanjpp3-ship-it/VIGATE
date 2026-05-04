#include <WiFi.h>
#include <WebServer.h>
#include <HTTPClient.h>
#include <esp_camera.h>

// Ganti dengan nama jaringan WiFi dan password Anda
const char* WIFI_SSID = "YOUR_SSID";
const char* WIFI_PASSWORD = "YOUR_PASSWORD";

// Ganti dengan alamat IP / domain Laravel Anda
const char* SERVER_BASE = "http://192.168.1.100:8000";

WebServer server(80);

void setup() {
  Serial.begin(115200);
  delay(1000);

  if (!initCamera()) {
    Serial.println("Gagal menginisialisasi kamera ESP32-CAM");
    while (true) {
      delay(1000);
    }
  }

  connectWiFi();

  server.on("/capture", HTTP_GET, handleCaptureRequest);
  server.onNotFound(handleNotFound);
  server.begin();
  Serial.println("ESP32-CAM siap menerima trigger pada /capture");
}

void loop() {
  server.handleClient();
}

bool initCamera() {
  camera_config_t config;
  config.ledc_channel = LEDC_CHANNEL_0;
  config.ledc_timer = LEDC_TIMER_0;
  config.pin_d0 = 5;
  config.pin_d1 = 18;
  config.pin_d2 = 19;
  config.pin_d3 = 21;
  config.pin_d4 = 36;
  config.pin_d5 = 39;
  config.pin_d6 = 34;
  config.pin_d7 = 35;
  config.pin_xclk = 0;
  config.pin_pclk = 22;
  config.pin_vsync = 25;
  config.pin_href = 23;
  config.pin_sscb_sda = 26;
  config.pin_sscb_scl = 27;
  config.pin_pwdn = 32;
  config.pin_reset = -1;
  config.xclk_freq_hz = 20000000;
  config.pixel_format = PIXFORMAT_JPEG;
  config.frame_size = FRAMESIZE_SVGA;
  config.jpeg_quality = 12;
  config.fb_count = 1;

  esp_err_t err = esp_camera_init(&config);
  if (err != ESP_OK) {
    Serial.printf("Camera init failed with error 0x%x\n", err);
    return false;
  }

  sensor_t *s = esp_camera_sensor_get();
  if (s != NULL) {
    s->set_framesize(s, FRAMESIZE_SVGA);
    s->set_vflip(s, 1);
    s->set_hmirror(s, 1);
  }

  return true;
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

void handleCaptureRequest() {
  String nfcUid = server.arg("nfc_uid");
  String status = server.arg("status");
  if (nfcUid.length() == 0) {
    server.send(400, "text/plain", "Parameter nfc_uid required");
    return;
  }
  if (status.length() == 0) {
    status = "unknown";
  }

  bool ok = captureAndUploadImage(nfcUid, status);
  if (ok) {
    server.send(200, "text/plain", "Capture and upload OK");
  } else {
    server.send(500, "text/plain", "Capture or upload failed");
  }
}

void handleNotFound() {
  server.send(404, "text/plain", "Not Found");
}

bool captureAndUploadImage(const String &nfcUid, const String &accessStatus) {
  camera_fb_t *fb = esp_camera_fb_get();
  if (!fb) {
    Serial.println("Gagal mengambil frame kamera");
    return false;
  }

  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
    if (WiFi.status() != WL_CONNECTED) {
      esp_camera_fb_return(fb);
      return false;
    }
  }

  String url = String(SERVER_BASE) + "/api/upload-image?nfc_uid=" + nfcUid + "&status=" + accessStatus;
  Serial.printf("Upload ke %s\n", url.c_str());

  HTTPClient http;
  http.begin(url);
  http.addHeader("Content-Type", "image/jpeg");

  int httpCode = http.POST(fb->buf, fb->len);
  String response = http.getString();
  http.end();
  esp_camera_fb_return(fb);

  if (httpCode == 201) {
    Serial.println("Upload berhasil");
    Serial.println(response);
    return true;
  }

  Serial.printf("Upload gagal, HTTP code: %d\n", httpCode);
  Serial.println(response);
  return false;
}
