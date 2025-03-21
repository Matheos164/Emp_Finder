//Div toggler for the action buttons
function divToggle(btn){
    var panel1 = document.getElementById("panel1");
    var panel2 = document.getElementById("panel2");
    var panel3 = document.getElementById("panel3");

    if (btn == 'panel1'){
        panel1.style.display = "block";
        panel2.style.display = "none";
        panel3.style.display = "none";
    }else if (btn == 'panel2'){
        panel1.style.display = "none";
        panel2.style.display = "block";
        panel3.style.display = "none";
    }else if (btn == 'panel3'){
        panel1.style.display = "none";
        panel2.style.display = "none";
        panel3.style.display = "block";      
    }
}

//-----------------------------------------------------------------------------------------------//

//displays the resaults
function showResault(btn){
    var res = document.getElementById("resault");
    res.style.display = "block";
}

//-----------------------------------------------------------------------------------------------//

// ajax function to send information to action.php to preform the remove preseadure
function remove(name, location, floor, cubical){

    var req = new Request('action.php', {
        method: 'post',
        type: 'basic', 
        headers: { "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"},
        body: 'action=remEMP&name=' + name + '&location=' + location + '&floor=' + floor + '&cubical=' + cubical
    });
    console.log(name, location, floor, cubical);
    fetch(req)
    .then(response => {return response.text();})
    .then(check);
}

// check for function operationa and reload call
function check(item){
    console.log(item);
    location.reload();
}

//-----------------------------------------------------------------------------------------------//

// show picture function to show floor plant map based on selected location and floor for add system
function showPictures(){
    const location = document.querySelector('input[name="location"]:checked').value;
    const floor = document.getElementById('floor').value;
    const imageContainer = document.getElementById('imageContainer');
    const floorDiv = document.getElementById('floorCont');
    floorDiv.style.display = 'block';

    switch(location){
        case 'john':
            //console.log('john');
            if(floor == 2){
                imageContainer.innerHTML = '<img src="john/john-2nd.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else if(floor == 3){
                imageContainer.innerHTML = '<img src="john/John-3rd.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else if(floor == 4){
                imageContainer.innerHTML = '<img src="john/John-4th.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else if(floor == 5){
                imageContainer.innerHTML = '<img src="john/john-5th.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else if(floor == 6){
                imageContainer.innerHTML = '<img src="john/John-6th.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else{
                imageContainer.innerHTML ='Error';
            }
            break;
        case 'nebo':
            //console.log('nebo');
            if(floor == 1){
                imageContainer.innerHTML = '<img src="Nebo/Nebo-1st.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else if(floor == 2){
                imageContainer.innerHTML = '<img src="Nebo/Nebo-2nd.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else{
                imageContainer.innerHTML ='Error';
            }
            break;
        case 'vansickle':
            //console.log('vansickle');
            if(floor == 1){
                imageContainer.innerHTML = '<img src="Vansickle/Vansickle-1st.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else if(floor == 2){
                imageContainer.innerHTML = '<img src="Vansickle/Vansickle-2nd.png" alt="FloorMap" id="FloorMap" class="">';
                imageContainer.style.display = 'block';
            }else{
                imageContainer.innerHTML ='Error';
            }
            break;
    }

}

function GenerateDropDown(){
    const location = document.querySelector('input[name="location"]:checked').value;
    const dropDiv = document.getElementById('floorCont');

    switch(location){
        case "john":
            console.log('john');
            dropDiv.innerHTML = '<label for="floor" class="lead">Floor</label><select name="floor" id="floor" onchange="showPictures();"><option value="2" >2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option></select>';
            break;
        case "nebo":
            console.log('nebo');
            dropDiv.innerHTML = '<label for="floor" class="lead">Floor</label><select name="floor" id="floor" onchange="showPictures();"><option value="1" >1</option><option value="2">2</option>/select>';
            break;
        case "vansickle":
            console.log('vansickle');
            dropDiv.innerHTML = '<label for="floor" class="lead">Floor</label><select name="floor" id="floor" onchange="showPictures();"><option value="1" >1</option><option value="2">2</option>/select>';
            break;
    }
}

