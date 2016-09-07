if (window.scriptURL !== window.location.href && window.alcuinJobId) {
	
    window.scriptURL = window.location.href

	$(document).ready(function() {
		// allow page time to run any scripts and render
	    var t = setTimeout(function() {
	    	if (document.visibilityState === "visible") {
	    		visible();
	        } else {
	            document.addEventListener('visibilitychange', visible, false);
	        }
	    }, 3500);
	});
	
	var beenVisible = false;
	
	var getHtml = getHtml || function () {
		return document.documentElement.innerHTML;
	}
	
	var visible = visible || function () {
	
	    if (document.visibilityState === "visible") {
	        if (beenVisible) {
	            return
	        }
	
            var html = getHtml();
	
	        chrome.runtime.sendMessage({
	            from: "alcuin",
	            action: "crawled",
	            jobId: window.alcuinJobId,
	            title: document.title,
	            text: html
	        }, function (r) {
	            if (r) {
	                beenVisible = true;
	                document.removeEventListener('visibilitychange', visible, false)
	            }
	        });
	    }
	}
}