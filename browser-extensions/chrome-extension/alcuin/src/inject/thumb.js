if (window.alcuinJobId && window.alcuinScreenshot) {
	
    window.scriptURL = window.location.href

	var img = new Image();
	img.src = window.alcuinScreenshot;
	var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');

    var width = window.innerWidth * 0.25,
    height = window.innerHeight * 0.25
    
    canvas.width = width;
    canvas.height = height;

    context.drawImage(img, 0, 0, width, height);

    var src = canvas.toDataURL('image/jpeg');
    
    chrome.runtime.sendMessage({
        from: "alcuin",
        action: "thumbed",
        jobId: window.alcuinJobId,
        img: src
    });
}