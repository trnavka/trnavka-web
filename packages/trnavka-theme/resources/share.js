const script = document.currentScript;
const canvas = script.previousElementSibling;

const campaignUrl = script.dataset["url"] ?? null;
const campaignView = script.dataset["view"] ?? null;
const onloadCallbackName = script.dataset["onload"] ?? null;
const onloadCallback = null === onloadCallbackName ? null : (window[onloadCallbackName] ?? null);

if (campaignUrl === null || campaignView === null) {
    console.log("Campaign URL or campaign view is not set.");
} else {
    canvas.innerHTML = '...';
    const url = new URL(script.src);
    const cacheBuster = Math.floor(new Date().getTime() / 300000) * 300;

    fetch(`${url.protocol}//${url.host}${campaignUrl}?view=${campaignView}&cb=${cacheBuster}`)
        .then((response) => {
            return response.text();
        })
        .then((html) => {
            canvas.innerHTML = html;

            if (null !== onloadCallback) {
                onloadCallback(html);
            }
        });
}
