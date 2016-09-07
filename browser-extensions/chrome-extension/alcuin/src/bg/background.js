!function(window, $, undefined) {

    var 	nasjah = {
    			reap: '{insert-base-url}/harvester/reap.php',
    			take: '{insert-base-url}/hopper/take.php?supports=crawl'
    }	,	jobList = []
    	,	cJobs = 1

    chrome.runtime.onMessage.addListener(function (msg, sender, respond) {

        if (msg.from === "alcuin") {
        	
        	console.log('Message <' + msg.action + '> for job <' + msg.jobId + '>');
        	
        	if(msg.action == "crawled") {
        		var     url = sender.tab.url
        		,	jobId = msg.jobId
                ,   text = msg.text
                ,   title = msg.title
        		
                var job = null;
        		for(var ix = 0; ix < jobList.length; ix++) {
        			if(jobId == jobList[ix].id) {
        				job = jobList[ix];
        				break;
        			}
        		}
        		if(!job) return;
        		
        		console.log('Crawled job ' + job.id + ' in window ' + job.windowId);
        		
        		job.result = {};
        		
        		job.result.date = new Date().toLocaleString();
        		job.result.title = title;
        		job.result.url = url;
        		job.result.html = text;
        		
        		chrome.tabs.captureVisibleTab(job.windowId, {format: "jpeg", quality: 80},
                    function (src) {
                        if (src) {
                            
                            chrome.tabs.executeScript(job.tabId, { code: 'window.alcuinJobId=' + job.id + '; window.alcuinScreenshot="' + src + '"' })
                            chrome.tabs.executeScript(job.tabId, {file: "src/inject/thumb.js", runAt: "document_start"}, function (result) {
                                if (chrome.runtime.lastError) {
                                	console.log('Error from thumb: ' + chrome.runtime.lastError);
                                    return;
                                }
                            })
                        } else {
                        	
                    		chrome.runtime.sendMessage({
                	            from: "alcuin",
                	            action: "reap",
                	            jobId: job.id
                	        });
                        	
                        }
        			}
                );
        	}
        	
        	if(msg.action == "thumbed") {
        		var     jobId = msg.jobId
                ,   src = msg.img
                
                var job = null;
        		for(var ix = 0; ix < jobList.length; ix++) {
        			if(jobId == jobList[ix].id) {
        				job = jobList[ix];
        				break;
        			}
        		}
        		if(!job) return;
        		
        		job.result.img = encodeURIComponent(src);
                
        		chrome.runtime.sendMessage({
    	            from: "alcuin",
    	            action: "reap",
    	            jobId: job.id
    	        });
        		
        	}
        	
        	if(msg.action == "reap") {
        		var     jobId = msg.jobId;
        		
        		var job = null;
        		for(var ix = 0; ix < jobList.length; ix++) {
        			if(jobId == jobList[ix].id) {
        				job = jobList[ix];
        				break;
        			}
        		}
        		if(!job) return;
        		
        		var result = job.result;
        		delete job['result'];
        		
        		$.ajax({
                  url: nasjah.reap,
                  type: "post",
                  dataType: "json",
                  data: {date: result.date, title: result.title, url: result.url, text: result.html, img: result.img, job: JSON.stringify({ id: job.id, payload: job.payload })},
                  contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                  success: function (result) {
                  		console.log(result);
                  		// delete the job
                  		var ixJob = 0;
                		for(var ix = 0; ix < jobList.length; ix++) {
                			if(job.id == jobList[ix].id) {
                				ixJob = ix;
                				break;
                			}
                		}
                		if(ixJob > -1)
                			jobList.splice(ixJob, 1);
                      },
                  error: function(result) {
                  		console.log(result + 'An error occurred');
                      }
        		});
        	}
        }

        // keeps the handler running (ref: Chrome API docs)
        return true
    });

    chrome.browserAction.onClicked.addListener(function(tab) {
    	refreshList(tab)
    })
    
    chrome.contextMenus.create({
    		'title' : 'Process with Alcuin',
    		'onclick' : function(info, tab) {
    			cJobs++;
    			console.log("Processing tab " + tab.id + "with Alcuin, creating job #" + cJobs);
    			var job = { id: 0 - cJobs, windowId: tab.windowId, tabId: tab.id, payload: { url : tab.url } };
				jobList.push(job);
				capture(job);
    		}
    });
    
    function refreshList(tab) {
    	$.ajax({
            type: "GET",
            url: nasjah.take,
            dataType: "json",
            complete: function( data ) {
            	var tWait = 5000;
            	if(data && data.responseJSON && data.responseJSON.length > 0) {
            		// add the urls to the list
            		for(var ix = 0; ix < data.responseJSON.length; ix++) {
            			var job = data.responseJSON[ix];
            			console.log('Adding: ' + job.payload.url);
            			jobList.push(job);
            		}
            	} else {
            		console.log('Nothing to add');
            		tWait = 30000;
            	}
            	setTimeout(function() {
            		processList(tab);
            	}, tWait)
        	}
       });
    }
    
    function processList(tab) {
    	var job = null;
    	for(var ix = 0; ix < jobList.length; ix++) {
			if(! jobList[ix].tabId) {
				job = jobList[ix];
				break;
			}
		}
    	if(job) {
    		console.log('Navigate to: ' + job.payload.url);
    		// todo add error handling for when tab has been closed
    		job.tabId = tab.id;
			job.windowId = tab.windowId;
    		chrome.tabs.update(tab.id, {url: job.payload.url});
    		setTimeout(function() {
        		processList(tab);
        	}, 9000)
    	} else {
    		setTimeout(function() {
    			refreshList(tab);
        	}, 15000)
    	}
    }
    
    chrome.tabs.onUpdated.addListener(function (tabId, changeInfo, tab) {
        if (changeInfo.status === "complete") {
        	check(tabId);
        }
    })

    chrome.tabs.onReplaced.addListener(function(tabId, removedTabId){
        check(tabId);
    });

    function check(tabId) {
    	var job = null;
		for(var ix = 0; ix < jobList.length; ix++) {
			if(tabId == jobList[ix].tabId) {
				job = jobList[ix];
				break;
			}
		}
		if(job) {
			capture(job);
		}
    }
    
    function esc(str) {
        return str.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')
    }

    function capture(job) {
        chrome.tabs.executeScript(job.tabId, {file: "vendor/jquery-2.1.0.min.js", runAt: "document_start"}, function (result) {
            if (chrome.runtime.lastError) {
            	console.log('Error from jquery: ' + chrome.runtime.lastError);
                return;
            }
        })
        chrome.tabs.executeScript(job.tabId, { code: 'window.alcuinJobId=' + job.id })
        chrome.tabs.executeScript(job.tabId, {file: "src/inject/crawl.js", runAt: "document_start"}, function (result) {
            if (chrome.runtime.lastError) {
            	console.log('Error from crawl: ' + chrome.runtime.lastError);
                return;
            }
        })
    }

    function dataURItoBlob(dataURI) {
        // convert base64 to raw binary data held in a string
        // doesn't handle URLEncoded DataURIs
        var byteString = atob(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

        // write the bytes of the string to an ArrayBuffer
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        // write the ArrayBuffer to a blob
        var bb;
        if ( typeof BlobBuilder != 'undefined' )
            bb = new BlobBuilder();
        else
            bb = new WebKitBlobBuilder();
        bb.append(ab);
        return bb.getBlob(mimeString);
    }

}(window,jQuery)