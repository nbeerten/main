window.TMASigns = {
    updatePreview: function({text, subtext, size, subtextlocation}) {
        if(text == '' || size == '') return;

// Not indented for better code syntax for jsondebug card
        var postData =
`{
    "format": "jpg",
    "size": ${size},
    "options": {
        "subtextlocation": "${subtextlocation}"
    },
    "text": "${text}",
    "subtext": "${subtext}"
}`;
        const jsondebug = document.querySelector("#jsondebug");
        jsondebug.textContent = postData;

        const previewImageParent = document.querySelector(':has(> #previewImage)');
        const previewImage = document.querySelector('#previewImage');

        const Headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json, image/jpg'
        };

        fetch('/api/tmasigns', {method: 'POST', headers: Headers, body: postData})
            .then((response) => {
                previewImageParent.setAttribute("data-status", response.status)
                previewImageParent.setAttribute("data-status-message", response.statusText)
                if(response.ok) {
                    response.blob()
                    .then((imageBlob) => {
                        if(imageBlob.type !== "image/jpg") return previewImage.src = '';
                        const objectURL = URL.createObjectURL(imageBlob);
                        previewImage.src = objectURL;
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

    downloadTGA: function({text, subtext, size, subtextlocation}) {
        if(text == '' || size == '') return;

        const downloadButton = document.querySelector('#downloadButton');
        var filename = 'tma_sign';
        filename += `${size}x1`;
        filename += `_${text}`;
        filename += (subtext !== "" ? `_${subtext}` : '');

        if(size == 6) downloadButton.download = `${filename}.tga`
        else downloadButton.download = `${filename}.zip`;

        var postData =
        `{
            "format": "tga",
            "size": ${size},
            "options": {
                "subtextlocation": "${subtextlocation}"
            },
            "text": "${text}",
            "subtext": "${subtext}"
        }`;
        const Headers = {
            'Content-Type': 'application/json'
        };

        fetch('/api/tmasigns', {method: 'POST', headers: Headers, body: postData})
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