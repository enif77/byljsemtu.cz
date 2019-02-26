/* Controls view description. */

function description_Init()
{
    // Description box.
    var descriptionElement = document.getElementById("description-icon");
    
    //descriptionElement.addEventListener("mouseover", showDescription);
    //descriptionElement.addEventListener("mouseout", hideDescription);
    descriptionElement.addEventListener("click", description_Toggle);

    /* 
        // https://www.w3schools.com/jsref/met_document_addeventlistener.asp
        document.addEventListener("click", function() {
            myFunction(p1, p2);
        });  
    */
}

function description_Show() 
{
    document.getElementById("description").style.display = "block";
}


function description_Hide() 
{
    document.getElementById("description").style.display = "none";
}


function description_Toggle() 
{
    if (document.getElementById("description").style.display == "block")
    {
        description_Hide();
    }
    else
    {
        description_Show();
    }
}