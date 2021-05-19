const dash = $('.dash');
const learnMoreDash = $('.lm-dash');
const learnMoreLink = $('.learn-more-link');
const topNavLink = $('.top-nav-li');
const portalBtn = $('.portal-btn');
const signinModal = $('.signin-modal-cont');
const signinCancel = $('#cancel');
const signinSubmit = $('#submit');


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

    $(signinCancel).on('click', () => {
        $(signinModal).hide(500);
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
    }

// function isValid(str){
//     return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
//    }

// $(document).ready(() => {
//     $(signinSubmit).on('click', (event) => {
//         event.preventDefault();
//         ValidatePassword();
//     });
// });