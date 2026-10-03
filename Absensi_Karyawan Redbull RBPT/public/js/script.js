const video = document.getElementById("video");
const statusText = document.getElementById("status");

async function startVideo() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
    video.srcObject = stream;
  } catch (err) {
    statusText.innerText = "Kamera tidak bisa diakses!";
    console.error(err);
  }
}

async function loadModels() {
  statusText.innerText = "Memuat model...";
  await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
  statusText.innerText = "Model siap, mendeteksi wajah...";
  startVideo();
}

video.addEventListener('play', () => {
  const canvas = faceapi.createCanvasFromMedia(video);
  document.body.append(canvas);

  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);

  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions());
    const resizedDetections = faceapi.resizeResults(detections, displaySize);

    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
    faceapi.draw.drawDetections(canvas, resizedDetections);

    if (detections.length > 0) {
      statusText.innerText = "Wajah terdeteksi ✅";
    } else {
      statusText.innerText = "Mendeteksi wajah...";
    }
  }, 200);
});

loadModels();
