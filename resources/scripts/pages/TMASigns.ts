import { Alpine as IAlpine } from 'alpinejs';

declare var Alpine: IAlpine;

declare global {
    interface Window {
        TMASigns: {
            updatePreview: Function,
            startLoadingAnimation: Function,
            downloadsign: Function,
            downloadLocators: Function
        };
    }
}

export interface TMASignsData {
    text: string, 
    subtext: string, 
    size: 1|2|4|6|null,
    subtextlocation: "bottom"|"top",
    offsetText: number|null, 
    offsetSubtext: number|null, 
    outlineModifier: number|null
}

export interface ILocatorTool {
    urls: Array<string>,
    newUrl: string,
    addUrl: Function,
    deleteUrl: Function,
}

export interface IPostData {
    format: "jpg"|"tga"|"webp",
    shouldOutputZip: boolean,
    size: 1|2|4|6,
    options: {
        subtextlocation: "bottom"|"top", 
        offsetText: number, 
        offsetSubtext: number, 
        outlineModifier: number
    },
    text: string, 
    subtext: string, 
}

window.TMASigns = {
    updatePreview: function({text, subtext, size, subtextlocation, offsetText, offsetSubtext, outlineModifier}: TMASignsData): void {
        // MS for response
        const startTime = performance.now();

        if(text == '' || size == null) return;

        const jsonDebugObject: IPostData = {
            format: (size != 6 ? "tga" : "jpg"),
            shouldOutputZip: (size != 6),
            size: size,
            options: {
                subtextlocation: subtextlocation,
                offsetText: offsetText ?? 0,
                offsetSubtext: offsetSubtext ?? 0,
                outlineModifier: outlineModifier ?? 0
            },
            text: text,
            subtext: subtext
        };

        const jsonDebugData = JSON.stringify(jsonDebugObject, null, "	");
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

        const postData: IPostData = {
            format: "jpg",
            shouldOutputZip: false,
            size: size ?? 2,
            options: {
                subtextlocation: subtextlocation ?? "bottom",
                offsetText: offsetText ?? 0,
                offsetSubtext: offsetSubtext ?? 0,
                outlineModifier: outlineModifier ?? 0,
            },
            text: text,
            subtext: subtext
        }

        const bodyData = JSON.stringify(postData);

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
                }
            })
    },

    startLoadingAnimation: function({ text }: { text: string }): void {
        if(text.length < 1) return;
        const previewImageParent = document.querySelector('#previewImage')?.parentElement;
            if(previewImageParent == null) return;
        previewImageParent.setAttribute("data-status-message", `Loading...`);
        if(previewImageParent.getAttribute("data-status") === "") previewImageParent.setAttribute("data-status", " ");
    },

    downloadsign: function({text, subtext, size, subtextlocation, offsetText, offsetSubtext, outlineModifier}: TMASignsData): void {
        const downloadButton: HTMLAnchorElement|null = document.querySelector('#downloadButton');
            if(downloadButton === null) return;
        
        if(text == '' || size == null) {
            downloadButton.removeAttribute('href');
            downloadButton.removeAttribute('download');
            return;
        }

        const fnText = text.replace(/ /g, '').toLowerCase();
        const fnSubtext = subtext ? subtext.replace(/ /g, '').toLowerCase() + '_' : '';
        const filename = `TMA2-text-${fnText}-${fnSubtext}${size}x1-UG`;

        if(size == 6) downloadButton.setAttribute('download', `${filename}.jpg`);
        else downloadButton.setAttribute('download', `${filename}.zip`);

        const postData: IPostData = {
            format: (size != 6 ? "tga" : "jpg"),
            shouldOutputZip: (size != 6),
            size: size ?? 2,
            options: {
                subtextlocation: subtextlocation ?? "bottom",
                offsetText: offsetText ?? 0,
                offsetSubtext: offsetSubtext ?? 0,
                outlineModifier: outlineModifier ?? 0
            },
            text: text,
            subtext: subtext
        };

        const bodyData = JSON.stringify(postData);

        fetch('/api/tmasigns', {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json'
            }, 
            body: bodyData
        })
            .then((response) => {
                if(response.ok) {
                response.blob()
                    .then((imageBlob) => {
                        const objectURL = URL.createObjectURL(imageBlob);
                        downloadButton.setAttribute('href', objectURL);
                        downloadButton.click();
                        URL.revokeObjectURL(objectURL);
                        downloadButton.removeAttribute('href');
                        downloadButton.removeAttribute('download');
                    });

                } else {
                    downloadButton.removeAttribute('href');
                    downloadButton.removeAttribute('download');
                }
            });
    },

    downloadLocators: function(): void {
        const locatorToolDownloadButton = document.querySelector('#locatorToolDownloadButton') as HTMLElement;

        const data = JSON.stringify((Alpine.store('locatorTool') as ILocatorTool).urls);
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
            });
    }
};