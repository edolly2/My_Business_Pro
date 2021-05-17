const dash = $('.dash');
const learnMoreDash = $('.lm-dash');
const learnMoreLink = $('.learn-more-link');
const topNavLink = $('.top-nav-li');


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
});

