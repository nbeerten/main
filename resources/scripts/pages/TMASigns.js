window.TMASigns = {
    updatePreview: function({text, subtext, size, subtextlocation}) {
        // MS for response
        const startTime = performance.now();

        if(text == '' || size == '') return;

// Not indented for better code syntax for jsondebug card
        const jsonDebugData = JSON.stringify({
            format: (size != 6 ? "tga" : "jpg"),
            size: size,
            options: {
                subtextlocation: subtextlocation
            },
            text: text,
            subtext: subtext
        }, null, "  ");
        const jsondebug = document.querySelector("#jsondebug");
        jsondebug.textContent = jsonDebugData;
        Prism.highlightAll();

        const previewImageParent = document.querySelector(':has(> #previewImage)');
        const previewImage = document.querySelector('#previewImage');

        const Headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json, image/jpg'
        };

        const bodyData = JSON.stringify({
            format: "jpg",
            size: size,
            options: {
                subtextlocation: subtextlocation
            },
            text: text,
            subtext: subtext
        });

        fetch('/api/tmasigns', {method: 'POST', headers: Headers, body: bodyData})
            .then((response) => {
                previewImageParent.setAttribute("data-status", response.status)
                previewImageParent.setAttribute("data-status-message", response.statusText)
                if(response.ok) {
                    response.blob()
                    .then((imageBlob) => {
                        if(imageBlob.type !== "image/jpg") return previewImage.src = '';
                        const objectURL = URL.createObjectURL(imageBlob);
                        previewImage.src = objectURL;
                        const endTime = performance.now();
                        previewImageParent.setAttribute("data-status-message", `${response.statusText} (${Math.round(endTime - startTime)}ms)`)
                    });
                }
                else {
                    response.json()
                    .then((data) => {
                        previewImage.src = ' ';
                        previewImageParent.setAttribute("data-status-message", data['message']);
                    });
                }
            })
    },

    downloadsign: function({text, subtext, size, subtextlocation}) {
        if(text == '' || size == '') return;

        const downloadButton = document.querySelector('#downloadButton');
        const fnText = text.replace(/ /g, '').toLowerCase();
        const fnSubtext = subtext ? subtext.replace(/ /g, '').toLowerCase() + '_' : '';
        const filename = `TMA2-text-${fnText}-${fnSubtext}${size}x1-UG`;

        if(size == 6) downloadButton.download = `${filename}.jpg`
        else downloadButton.download = `${filename}.zip`;

        const bodyData = JSON.stringify({
            format: (size != 6 ? "tga" : "jpg"),
            size: size,
            options: {
                subtextlocation: subtextlocation
            },
            text: text,
            subtext: subtext
        });
        const Headers = {
            'Content-Type': 'application/json'
        };

        fetch('/api/tmasigns', {method: 'POST', headers: Headers, body: bodyData})
            .then((response) => {
                if(response.ok) {
                response.blob()
                    .then((imageBlob) => {
                        const objectURL = URL.createObjectURL(imageBlob);
                        downloadButton.href = objectURL;
                        downloadButton.click();
                        URL.revokeObjectURL(objectURL);
                    });
                } else downloadButton.href = "";
            });
    },

    downloadLocators: function() {

        const locatorToolDownloadButton = document.querySelector('#locatorToolDownloadButton');

        const data = JSON.stringify(Alpine.store('locatorTool').urls);
        const postData = `{ "urls": ${data} }`;

        const Headers = {
            'Content-Type': 'application/json'
        };

        fetch('/api/tmasigns/locatortool', {method: 'POST', headers: Headers, body: postData})
            .then((response) => {
                if(response.ok) {
                    response.blob()
                    .then((responseBlob) => {
                        const objectURL = URL.createObjectURL(responseBlob);
                        locatorToolDownloadButton.href = objectURL;
                        locatorToolDownloadButton.click();
                        URL.revokeObjectURL(objectURL);
                    });
                } else locatorToolDownloadButton.href = "";
            });
    }
};