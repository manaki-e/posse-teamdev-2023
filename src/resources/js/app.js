import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

let currentURL = window.location.href;
console.log(currentURL);
let app_name = "";

if (currentURL.includes("/items")) {
    app_name = "item";
} else if (currentURL.includes("/events")) {
    app_name = "event";
} else if (currentURL.includes("/requests")) {
    app_name = "request";
}

console.log(app_name);

let likes = document.querySelectorAll(".likes");
//foreach likes, if clicked, change color and send ajax product to route('products.like') or route('products.unlike')
likes.forEach((like) => {
    like.addEventListener("click", () => {
        //get isLiked data from element
        let isLiked = like.dataset.is_liked;
        //get product id from element
        let id = like.dataset[app_name + "_id"];
        //get like count element
        let likeCount = like.querySelector(".like-count");
        //if isLiked is true, send unlike product
        if (isLiked === "1") {
            axios
                .post("/" + app_name + "s/" + id + "/unlike")
                .then(function (response) {
                    //change isLiked data to false
                    like.setAttribute("data-is_liked", 0);
                    //change svg color to gray
                    like.querySelector("svg").style.fill = "none";
                    //decrease like count
                    likeCount.innerHTML = parseInt(likeCount.innerHTML) - 1;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        //if isLiked is false, send like product
        else {
            axios
                .post("/" + app_name + "s/" + id + "/like")
                .then(function (response) {
                    //change isLiked data to true
                    like.setAttribute("data-is_liked", 1);
                    //change svg color to red
                    like.querySelector("svg").style.fill = "red";
                    //increase like count
                    likeCount.innerHTML = parseInt(likeCount.innerHTML) + 1;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    });
});
