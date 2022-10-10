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

        const previewImage = document.querySelector('#previewImage');

        const Headers = {
            'Content-Type': 'application/json'
        };

        fetch('/api/tmasigns', {method: 'POST', headers: Headers, body: postData})
            .then((response) => response.blob())
            .then((imageBlob) => {
                if(imageBlob.type !== "image/jpg") return previewImage.src = '';
                const objectURL = URL.createObjectURL(imageBlob);
                previewImage.src = objectURL;
            });
    },

    downloadTGA: function({text, subtext, size, subtextlocation}) {
        if(text == '' || size == '') return;

        const downloadButton = document.querySelector('#downloadButton');
        if(size == 6) downloadButton.download = `tma_sign${size}x1_${text}.tga`
        else downloadButton.download = `tma_sign${size}x1_${text}.zip`;
        
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
            .then((response) => response.blob())
            .then((imageBlob) => {
                const objectURL = URL.createObjectURL(imageBlob);
                downloadButton.href = objectURL;
                downloadButton.click();
                URL.revokeObjectURL(objectURL);
            });
    }
};