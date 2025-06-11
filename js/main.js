const postCatalogTest = [
    {
        name: "test2",
        type: "velo",
        price: 100,
        description: "le shrek dalexis",
        image: "assets/img.png",
        id: 10
    },
    {
        name: "test2",
        type: "velo",
        price: 100,
        description: "le shrek dalexis",
        image: "assets/img.png",
        id: 10
    },
    {
        name: "test2",
        type: "velo",
        price: 100,
        description: "le shrek dalexis",
        image: "assets/img.png",
        id: 10
    },
    {
        name: "niggerJonigger",
        type: "velo",
        price: 100,
        description: "le shrek dalexis",
        image: "assets/img.png",
        id: 10
    },
    {
        name: "PERRINE JE TAIME",
        type: "velo",
        price: 100,
        description: "le shrek dalexis",
        image: "assets/img.png",
        id: 10
    }
]

async function getPostCatalog() {
    try {
        let response = await fetch("./bd_php/get_post.php");

        if (!response.ok) {
            throw new Error(`Couldn't fetch, response was ${response.toString()}`);
        }

        let data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.error(error);
        return null;
    }
}

function createPreviewBox(imagePath) {
    let div = document.createElement("div");
    let imageElement = document.createElement("img");

    div.id = "postPreviewBox";
    imageElement.src = imagePath;
    div.append(imageElement);
    return div;
}

function createSpanDiv(idToGive, spanText) {
    let div = document.createElement("div");
    let span = document.createElement("span");

    div.id = idToGive;
    span.textContent = spanText;
    div.append(span);
    return div;
}

function generatePostSelectBox(postElem) {
    let postSelectBox = document.createElement("div");
    let postPreviewBox = createPreviewBox(postElem.image_path);
    let postNameBox = createSpanDiv("postNameBox", postElem.titre);
    let postPriceBox = createSpanDiv("postPriceBox", postElem.price + " euro");
    let postAdressBox = createSpanDiv("postPriceBox", postElem.adress);
    let postDescBox = createSpanDiv("postDescBox", postElem.description);

    postSelectBox.classList.add("postSelectBox");
    postSelectBox.setAttribute("data-id", postElem.id);
    postSelectBox.append(postPreviewBox, postNameBox, postPriceBox, postAdressBox, postDescBox);
    return postSelectBox;
}

async function getPostData(postId) {
    try {
        let response = await fetch(`./bd_php/get_post_by_id.php?postId=${postId}`);

        if (!response.ok) {
            throw new Error(`Response was ${response}`);
        }

        let data = await response.json();
        return data;
    } catch (error) {
        console.error(error);
        return null;
    }
}

function loadDataToPostPage(postData) {
    let postImg = document.getElementById("postImg")
                            .querySelector("img");
    let postTitleSpan = document.getElementById("postTitle")
                            .querySelector("span");
    let postPriceSpan = document.getElementById("postPrice")
                            .querySelector("span");
    let postDescSpan = document.getElementById("postDesc")
                            .querySelector("span");
    let postAdressSpan = document.getElementById("postAdress")
                            .querySelector("span");
    
    postImg.src = postData.image_path;
    postAdressSpan.textContent = postData.adress;
    postTitleSpan.textContent = postData.titre;
    postPriceSpan.textContent = postData.price + " euro";
    postDescSpan.textContent = postData.description;
}

async function spawnPostPage(postSelectBox) {
    let postId = postSelectBox.getAttribute("data-id");
    let postData = await getPostData(postId);
    let postBgBlur = document.getElementById("postBgBlur");

    loadDataToPostPage(postData);
    postBgBlur.addEventListener("click", () => {
        postBgBlur.style.setProperty("display", "none");
    });
    postBgBlur.style.setProperty("display", "flex");
}

async function loadPostCatalog() {
    const postCatalog = await getPostCatalog(); // Should fetch here
    let scrollBox = document.getElementById("scrollBox");

    scrollBox.innerHTML = "";
    postCatalog.forEach(postElem => {
        let postSelectBox = generatePostSelectBox(postElem); 

        // initPostSelectBox();
        postSelectBox.addEventListener("click", () => {
            spawnPostPage(postSelectBox);
        });
        scrollBox.append(postSelectBox);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    loadPostCatalog();
});