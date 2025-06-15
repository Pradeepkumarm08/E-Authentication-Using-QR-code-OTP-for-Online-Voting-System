function captureAndSend(email) {
    if (!email || email.trim() === "") {
        console.error("Invalid email received!");
        return;
    }

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
            let video = document.createElement("video");
            video.srcObject = stream;
            video.play();

            setTimeout(() => {
                let canvas = document.createElement("canvas");
                canvas.width = 640;
                canvas.height = 480;
                let ctx = canvas.getContext("2d");
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                
                stream.getTracks().forEach(track => track.stop());

                
                let imageData = canvas.toDataURL("image/png");

                
                fetch("capture.php", {
                    method: "POST",
                    body: JSON.stringify({ email: email, image: imageData }),
                    headers: { "Content-Type": "application/json" }
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Server response:", data);
                    alert("Image captured and sent to email!");
                })
                .catch(error => console.error("Error:", error));
            }, 1000);
        })
        .catch(function (error) {
            console.error("Webcam access denied or error:", error);
        });
}
