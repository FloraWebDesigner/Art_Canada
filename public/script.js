
function getSearch() {
    let btn=document.getElementById("searchInfo");
    let search = document.querySelector(".searchForm");
    if(search.style.display==="none")
    {search.style.display="block";
        btn.textContent="Collapse";
    }
    else{
        search.style.display="none";
        btn.textContent="Get Search";
    }
}

function confirmDeleteAdmin(id, name) {
    let confirmDelete = window.confirm("Are you sure you want to delete " + name + "?");
    if (confirmDelete) {
        window.location.href = 'adminTable.php?delete=' + id;
    }
    else{
        return false;
    }
}

function confirmDeleteFacilityCard(id, name) {
    let confirmDelete = window.confirm("Are you sure you want to delete " + name + "?");
    if (confirmDelete) {
        window.location.href = 'facility-admin.php?delete=' + id;
    }
    else{
        return false;
    }
}



