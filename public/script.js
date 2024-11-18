
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


function clearSearch(event) {
console.log("run clear search");
document.querySelector(".searchForm").reset();
    window.location.href = 'all-facilities.php';
    event.preventDefault();
}






function confirmDeleteAdmin(id, name) {
    let confirmDelete = window.confirm("Are you sure you want to delete " + name + "?");
    if (confirmDelete) {
        window.location.href = 'admin-list.php?delete=' + id;
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


function confirmDeleteBooking(id, name, date) {
    let confirmDelete = window.confirm("Are you sure you want to delete your reservation of " + name + " on "+date+" ?");
    if (confirmDelete) {
        window.location.href = 'user-home.php?delete=' + id;
    }
    else{
        return false;
    }
}




function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }

function alertFeedback(commentID,updateID) {
    if(commentID){
        let confirm = window.confirm("The item has been updated successfully. Do you want to update the status of #"+commentID+" Facility for the user request?");
        if(confirm)
        {
    window.location.href='feedback-status.php?id='+commentID;
}
    else{
    window.location.href='facility-admin.php?review_id='+updateID+'&commentID='+commentID;
}}
}

// https://developers.google.com/maps/documentation/javascript/examples/icon-complex#maps_icon_complex-javascript


