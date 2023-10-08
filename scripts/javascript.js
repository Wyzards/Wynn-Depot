$(document).ready(function () {
    sortTable();

    $("#refreshapi").click(function () {
        var ajaxurl = "php/refresh-api.php",
            data = {};
        $.post(ajaxurl, data);
    });
});

async function uploadImage(input, itemName) {
    let formData = new FormData();
    let fileName = input.files[0].name;

    formData.append("file", input.files[0]);
    formData.append("name", input.name);

    await fetch("../php/upload-image.php", {
        method: "POST",
        body: formData
    }).then(response => {
        let imgId = "#" + input.id + "-image";

        if ($(imgId).length)
            $(imgId).attr("src", "images/" + fileName);
        else {
            $('<img id="' + input.id + '-image" src="images/' + fileName + '" />').insertAfter("#" + input.id);
            $('<button style="display:\"\"" id="remove-' + input.id + '-image" onclick="removeItemImage(\'' + input.id + '\', \'' + itemName + '\')">Remove Image</button>').insertAfter("#" + input.id + "-image");
        }
    });
}

async function setAccountName(input) {
    let formData = new FormData();
    formData.append("name", input.id);
    formData.append("account", input.innerHTML)

    await fetch("../php/set-account-name.php", {
        method: "POST",
        body: formData
    });
}

async function setPercent(input) {
    if (!isNaN(input.innerHTML)) {
        let formData = new FormData();
        formData.append("name", input.id);
        formData.append("percent", input.innerHTML)

        await fetch("../php/set-percent.php", {
            method: "POST",
            body: formData
        });
    }
}

async function removeItemImage(itemId, itemName) {
    let formData = new FormData();

    formData.append("itemName", itemName);

    await fetch("../php/removeImg.php", {
        method: "POST",
        body: formData
    }).then(response => {
        document.getElementById(itemId + "-image").remove();
        document.getElementById("remove-" + itemId + "-image").setAttribute("style", "display:none");
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
            var data = cells[1].innerHTML.trim().split("<br>");
            var item = {};

            data.forEach(keypair => {
                var key = keypair.split(": ")[0];
                var value = keypair.split(": ")[1];
                item[key] = value;
            });

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
                else if (misc.includes("not-owned") && (cells[2].textContent.trim() !== "" || cells[3].textContent.trim() !== ""))
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