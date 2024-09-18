
//JavaScript event listener that waits for the entire HTML document to be fully loaded and parsed.
document.addEventListener('DOMContentLoaded',function()
{
    //add event listener to detect form submit event

    document.addEventListener('submit',function()
{   
    //assign username into a variable

    let username = document.getElementById('user-name').value;

    //give an alert to user
    alert(`Hello ${username}! You Already there.Click ok to continue`);

    //call CheckPswLenght() fucntion
    CheckPswLenght(event);
    
})
    
})
//function to load signup page
function RedirectToSignup()
{
    window.location.href = 'signup.html';
    
}
//function to load signin page
function RedirectToSignin()
{
    window.location.href = '../Login/Login.html';
}

//this function use to check password length

function CheckPswLenght(event)
{
    //assign password value into a variable

    let psw = document.getElementById('password').value;

    //check length

    if(psw.length < 8)
    {
        //if length is less than 8,prevent submitting the form and display error.

        event.preventDefault();
        alert("Please enter valid Passwrod");
        document.getElementById('ErrorMsg').innerHTML = "Password must have at least 8 characters"; 
    }
    else
    {
        document.getElementById('ErrorMsg').innerHTML = ""; 

    }
}