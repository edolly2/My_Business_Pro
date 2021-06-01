const dash = $('.dash');
const learnMoreDash = $('.lm-dash');
const learnMoreLink = $('.learn-more-link');
const topNavLink = $('.top-nav-li');
const portalBtn = $('.portal-btn');
const signinModal = $('.signin-modal-cont');
const signinCancel = $('#cancel');
const signinSubmit = $('#submit');
const mainHome = $('.main-home');
const main1 = $('.main1');
const getStartedBtn = ('.get-started-btn');
const signinExitBtn = ('.signin-exit-btn');
const account = $('#account');
const detailsForm = $('.details-form-cont');
const detailsFormSubmit = $('#details-submit');
const submitModal = $('.submit-modal-cont');
// REGISTER PAGE
const signupCancelBtn = $('#sign-up-cancel-btn')

// HMABURGER MENU
const hamburgerMenu = $('.hamburger-menu-cont');
const hamburgerMenuShowBtn = $('.hamburger');
const hamburgerMenuHideBtn = $('.hamburger-menu-hide-btn');
const hamburgerMenuHideCont = $('.hamburger-menu-hide-cont');

$(document).ready(() => {
    $(dash).css('visibility', 'hidden');
    // LEARN MORE HOVER EVENT
    $(learnMoreDash).hide();
    $(learnMoreLink).on('mouseover', () => {
        $(learnMoreDash).show();
    });
    $(learnMoreLink).on('mouseleave', () => {
        $(learnMoreDash).hide();
    });
    // NAV-LINK SELECTED CLICK EVENT
    $('.top-nav a').on('click', (e) => {
        $('.top-nav a').children(dash).css('visibility', 'hidden');
        $('.top-nav a').removeClass('selected');
        $(e.target).addClass('selected');
        if ($(e.target).hasClass('selected')) {
            $(e.target).children(dash).css('visibility', 'visible');
        }
    });

    // CUSTOMER PORTAL EVENT SIGN IN
    $(portalBtn).on('click', () => {
        $(signinModal).toggle(500);
    });

    $(account).on('click', () => {
        $(signinModal).toggle(500);
    });

    $(signinExitBtn).on('click', () => {
        $(signinModal).hide(500);
    });

let signedin = true;
    $(getStartedBtn).on('click', () => {
        if(signedin === false) {
            $(signinModal).show(500);
        }
        else {
            $(detailsForm).show(500);
        }
    });

    $(detailsFormSubmit).on('click', () => {
        $(detailsForm).hide(500);
        setTimeout(() => {
            $(submitModal).show(500);
            $(submitModal).delay(4000).hide(500);
        }, 1000);
    });

        $('.details-exit-btn').on('click', () => {
            $(detailsForm).hide(500);
        });
    
    });



    const slider = document.getElementById("budget")
    const output = document.getElementById("budget-amount")
    output.innerHTML = slider.value;
                            
    slider.oninput = function() {
    output.innerHTML = this.value;
    }

// REGISTER PAGE

$(document).ready(() => {
    $(signupCancelBtn).on('click', () => {
        $(document).location.href = "http://localhost/MY_BUSINESS_PRO/index.php";
    });
});

// HAMBURGER MENU

$(document).ready(() => {
    $(hamburgerMenuShowBtn).on('click', () => {
        $(hamburgerMenu).slideDown(500);
        $(hamburgerMenuShowBtn).hide();
        setTimeout(() => {
            $(hamburgerMenuHideCont).delay(500).fadeIn(500);
        }, 400);
    });

    $(hamburgerMenuHideBtn).on('click', () => {
        $(hamburgerMenu).slideUp(500);
        $(hamburgerMenuHideCont).fadeOut(500);
        setTimeout(() => {
            $(hamburgerMenuShowBtn).delay(500).fadeIn(500);
        }, 400);
    });
});


    // let format = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
    // const regex = new RegExp('foo*');
    // const format = /(?=.*[!@#$%^&*])/;
// let password = document.getElementsByName('password')[0].value;
// let email = document.getElementsByName('email')[0].value;

// function ValidateEmail(inputText) {
//     const mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
//     if (inputText.value.match(mailformat)) {
//         alert("Valid email address!");
//         document.email.focus();
//         return true;
//     } else {
//         alert("You have entered an invalid email address!");
//         document.email.focus();
//         return false;
//     }
// }

// function ValidatePassword(inputText) {
//     inputText = password;
//     console.log(inputText);
    
    // let ans = format.test(inputText);
    // console.log(ans);
    // if (format.search(inputText)) {
    //     alert('true');
    //     return true;
    // } else {
    //     alert('wrong')
    //     return false;
        // }
        // if (inputText.length < 7) {
        //     alert(`please enter valid password.
        //     your password must contain:
        //     -one capital letter
        //     -one special character
        //     -at least 8 characters`);
        // }
    // }

// function isValid(str){
//     return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
//    }

// $(document).ready(() => {
//     $(signinSubmit).on('click', (event) => {
//         event.preventDefault();
//         ValidatePassword();
//     });
// });
