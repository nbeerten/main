declare var TMASigns, Alpine, umami;

window.TMASigns = {
    updatePreview: function({text, subtext, size, subtextlocation, offsetText, offsetSubtext, outlineModifier}) {
        // MS for response
        const startTime = performance.now();

        if(text == '' || size == '') return;

        const jsonDebugData = JSON.stringify({
            format: (size != 6 ? "tga" : "jpg"),
            size: size,
            options: {
                subtextlocation: subtextlocation,
                offsetText: offsetText,
                offsetSubtext: offsetSubtext,
                outlineModifier: outlineModifier
            },
            text: text,
            subtext: subtext
        }, null, "  ");
        const jsondebug = document.querySelector("#jsondebug") as HTMLElement;
            if(jsondebug == null) return;
        jsondebug.textContent = jsonDebugData;

        const previewImage = document.querySelector('#previewImage') as HTMLElement;
            if(previewImage == null) return;
        const previewImageParent = previewImage.parentElement as HTMLElement;
            if(previewImageParent == null) return;

        const Headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json, image/jpg'
        };

        const bodyData = JSON.stringify({
            format: "jpg",
            size: size,
            options: {
                subtextlocation: subtextlocation,
                offsetText: offsetText,
                offsetSubtext: offsetSubtext,
                outlineModifier: outlineModifier,
            },
            text: text,
            subtext: subtext
        });

        fetch('/api/tmasigns', {method: 'POST', headers: Headers, body: bodyData})
            .then((response) => {
                previewImageParent.setAttribute("data-status", response.status.toString())
                previewImageParent.setAttribute("data-status-message", response.statusText)
                if(response.ok) {
                    response.blob()
                    .then((imageBlob) => {
                        if(imageBlob.type !== "image/jpg") return previewImage.setAttribute('src', '');
                        const objectURL = URL.createObjectURL(imageBlob);
                        previewImage.setAttribute('src', objectURL);
                        previewImage.classList.remove("loading");
                        const endTime = performance.now();
                        previewImageParent.setAttribute("data-status-message", `${response.statusText} (${Math.round(endTime - startTime)}ms)`);
                    });
                }
                else {
                    response.json()
                    .then((data) => {
                        previewImage.setAttribute('src', ' ');
                        previewImageParent.setAttribute("data-status-message", data['message']);
                    });

                    umami.trackEvent('tmasigns-preview-error', { type: 'api' });
                }
            })
    },

    startLoadingAnimation: function({text}) {
        if(text.length < 1) return;
        const previewImageParent = document.querySelector('#previewImage')?.parentElement;
            if(previewImageParent == null) return;
        previewImageParent.setAttribute("data-status-message", `Loading...`);
        if(previewImageParent.getAttribute("data-status") === "") previewImageParent.setAttribute("data-status", " ");
    },

    downloadsign: function({text, subtext, size, subtextlocation, offsetText, offsetSubtext, outlineModifier}) {
        if(text == '' || size == '') return;

        const downloadButton: HTMLElement = document.querySelector('#downloadButton') as HTMLElement;
            if(downloadButton === null) return;
        const fnText = text.replace(/ /g, '').toLowerCase();
        const fnSubtext = subtext ? subtext.replace(/ /g, '').toLowerCase() + '_' : '';
        const filename = `TMA2-text-${fnText}-${fnSubtext}${size}x1-UG`;

        if(size == 6) downloadButton.setAttribute('download', `${filename}.jpg`);
        else downloadButton.setAttribute('download', `${filename}.zip`);

        const bodyData = JSON.stringify({
            format: (size != 6 ? "tga" : "jpg"),
            size: size,
            options: {
                subtextlocation: subtextlocation,
                offsetText: offsetText,
                offsetSubtext: offsetSubtext,
                outlineModifier: outlineModifier
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
                        downloadButton.setAttribute('href', objectURL);
                        downloadButton.click();
                        URL.revokeObjectURL(objectURL);
                    });

                umami.trackEvent('tmasigns-download', { type: 'api' });
                } else downloadButton.setAttribute('href', " ");
            });
    },

    downloadLocators: function() {
        const locatorToolDownloadButton = document.querySelector('#locatorToolDownloadButton') as HTMLElement;

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
                        locatorToolDownloadButton.setAttribute('href', objectURL);
                        locatorToolDownloadButton.click();
                        URL.revokeObjectURL(objectURL);
                    });
                } else locatorToolDownloadButton.setAttribute('href', "");

                umami.trackEvent('tmasigns-locators', { type: 'api' });
            });
    }
};