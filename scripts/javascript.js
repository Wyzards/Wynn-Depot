$(document).ready(function () {
    sortTable();

    $("#refreshapi").click(function () {
        var ajaxurl = "php/refresh-api.php",
            data = {};
        $.post(ajaxurl, data);
    });

    $("img.item-image").click(function () {
        showImage($(this).data("item-id"));
    });

    $(".close").click(function () {
        $("#myModal").css("display", "none");
    });

    window.onclick = function (event) {
        if (event.target == document.getElementById("myModal"))
            $("#myModal").css("display", "none");
    }
});

async function uploadImage(input) {
    let formData = new FormData();
    let fileName = input.files[0].name;
    let itemId = $(input).data("item-id");
    let itemName = $(input).data("item-name");

    formData.append("file", input.files[0]);
    formData.append("name", itemName);

    await fetch("../php/upload-image.php", {
        method: "POST",
        body: formData
    }).then(response => {
        $("img[data-item-id='" + itemId + "']").attr("src", "images/" + fileName);
        $("input[data-item-id='" + itemId + "']").css("display", "none");
        $("button[data-item-id='" + itemId + "'].show-image").css("display", "");
        $("button[data-item-id='" + itemId + "'].remove-image").css("display", "");
        showImage(itemId);
        clearInputFile(input);
    });
}

async function setAccountName(input) {
    let formData = new FormData();
    formData.append("name", $(input).data("item-name"));
    formData.append("account", input.innerText)

    await fetch("../php/set-account-name.php", {
        method: "POST",
        body: formData
    });
}

async function setPercent(input) {
    if (!isNaN(input.innerText) && Number(input.innerText) <= 100) {
        let formData = new FormData();
        formData.append("name", $(input).data("item-name"));
        formData.append("percent", input.innerText)

        await fetch("../php/set-percent.php", {
            method: "POST",
            body: formData
        });
    }
}

async function removeItemImage(button) {
    let formData = new FormData();
    let itemId = $(button).data("item-id");
    let itemName = $(button).data("item-name");

    formData.append("itemName", itemName);

    await fetch("../php/removeImg.php", {
        method: "POST",
        body: formData
    }).then(response => {
        $("img[data-item-id='" + itemId + "']").attr("src", "");
        $("input[data-item-id='" + itemId + "']").css("display", "");
        $("button[data-item-id='" + itemId + "'].show-image").css("display", "none");
        $("button[data-item-id='" + itemId + "'].remove-image").css("display", "none");
    });
}

function sortTable() {
    const getCellValue = (tr, index) => tr.children[index].innerText || tr.children[index].textContent;
    const comparer = (index, ascending) => (a, b) => ((v1, v2) =>
        v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
    )(getCellValue(ascending ? a : b, index), getCellValue(ascending ? b : a, index));

    document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
        const table = th.closest('table');
        Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
            .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
            .forEach(tr => table.appendChild(tr));
    })));
}

function applySearchFilter() {
    let misc = [...document.getElementById("misc-filter").selectedOptions].map(option => option.value);
    let type = [...document.getElementById("type-filter").selectedOptions].map(option => option.value);
    let tier = [...document.getElementById("rarity-filter").selectedOptions].map(option => option.value);
    let levels = [...document.getElementById("level-filter").selectedOptions].map(option => option.value);

    var minLevel = 0;
    var maxLevel = 200;

    if (levels.length > 0) {
        minLevel = 100;
        maxLevel = 0;

        levels.forEach(levelRange => {
            let arr = levelRange.split("-");
            let low = Number(arr[0]);
            let high = Number(arr[1]);

            if (Number(low) < minLevel)
                minLevel = Number(low);

            if (Number(high) > maxLevel)
                maxLevel = Number(high);
        });
    }

    let table = document.getElementById("my-table");
    let rows = table.getElementsByTagName("tr");

    for (i = 0; i < rows.length; i++) {
        cells = rows[i].getElementsByTagName("td");

        if (cells[1]) {
            var item = JSON.parse(cells[2].innerText);

            rows[i].style.display = "";

            searchbar = document.getElementById("searchbar");
            filter = searchbar.value.toUpperCase();

            if (cells[0].textContent.trim() !== "" || cells[1].textContent.trim() !== "") {
                td = (cells[0].textContent.trim() !== "" ? cells[0].textContent.trim() : "") + (cells[2].textContent.trim() !== "" ? cells[2].textContent.trim() : "");

                if (!td.toUpperCase().includes(filter))
                    rows[i].style.display = "none";
            }

            if (tier.length > 0)
                if (!tier.includes(item["tier"].toLowerCase()))
                    rows[i].style.display = "none";

            if (misc.length > 0) {
                if (misc.includes("owned") && cells[3].textContent.trim() === "" && cells[4].textContent.trim() === "")
                    rows[i].style.display = "none";
                else if (misc.includes("not-owned") && cells[2].textContent.trim() !== "" && cells[3].textContent.trim() !== "")
                    rows[i].style.display = "none";
                else if (misc.includes("untradable") && (!item.hasOwnProperty("restrictions") || item["restrictions"] !== "Untradable"))
                    rows[i].style.display = "none";
                else if (misc.includes("quest") && (!item.hasOwnProperty("restrictions") || item["restrictions"] !== "Quest Item"))
                    rows[i].style.display = "none";
            }

            if (type.length > 0)
                if (item["type"] && !type.includes(item["type"].toLowerCase()))
                    rows[i].style.display = "none";
                else if (item["accessoryType"] && !type.includes(item["accessoryType"].toLowerCase()))
                    rows[i].style.display = "none";

            if (levels.length > 0 && (Number(item["level"]) < minLevel || Number(item["level"]) > maxLevel))
                rows[i].style.display = "none";
        }
    }
}

function clearInputFile(f) {
    if (f.value) {
        try {
            f.value = ''; //for IE11, latest Chrome/Firefox/Opera...
        } catch (err) { }
        if (f.value) { //for IE5 ~ IE10
            var form = document.createElement('form'),
                parentNode = f.parentNode, ref = f.nextSibling;
            form.appendChild(f);
            form.reset();
            parentNode.insertBefore(f, ref);
        }
    }
}

function showImage(itemId) {
    $("#modal-image").attr("src", $("img[data-item-id='" + itemId + "']").attr("src"));
    $("#myModal").css("display", "flex");
}