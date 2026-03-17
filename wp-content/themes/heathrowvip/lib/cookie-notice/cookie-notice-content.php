<div class="cookie-notice">
    <div class="cookie-notice-banner">
        <div class="cookie-notice-banner-text">
            <h4>We Value Your Privacy</h4>
            <p>We use ‘cookies’ and related technologies to help identify you and your devices, to operate our site, enhance your experience and conduct advertising and analysis. Some of these cookies are optional and are only used when you’ve agreed to them. You can consent to all our optional cookies at once, or manage your own preferences through the “manage choices” link. You can read more about these uses in our <a href="/privacy-policy">Privacy Statement</a>.</p>
        </div>
        <div class="cookie-notice-banner-buttons">
            <button class="manage-cookies open-cookie-options">Manage preferences</button>
            <button class="accept-all-cookies">Accept all</button>
        </div>
        
    </div>   
    <div class="manage-cookies-wrapper">
        <div class="manage-cookies-inner">
            <div class="manage-cookies-header">
                <h3>Privacy Preference Center</h3>
                <button class="close-cookie-options">X</button>
            </div>
            <div class="manage-cookies-body">

                <div class="nav-items">
                    <a href="#value-privacy">We Value Your Privacy</a>
                    <a href="#necessary-cookies">Strictly Necessary Cookies</a>
                    <!-- <a href="#functional-cookies">Functional Cookies</a>
                    <a href="#performance-cookies">Performance Cookies</a> -->
                    <a href="#targeting-cookies">Targeting Cookies</a>
                </div>

                <div class="manage-cookie-panels">
                    <div class="manage-cookies-panel manage-cookies-panel--value-privacy active">
                        <h3>We Value Your Privacy</h3>
                        <p>
                            When you visit any website, it may store or retrieve information on your browser, mostly in the form of cookies. This information might be about you, your preferences or your device and is mostly used to make the site work as you expect it to. The information does not usually directly identify you, but it can give you a more personalized web experience. Because we respect your right to privacy, you can choose not to allow some types of cookies. Click on the different category headings to find out more and change our default settings. However, blocking some types of cookies may impact your experience of the site and the services we are able to offer.
                        </p>
                    </div>
                    <div class="manage-cookies-panel manage-cookies-panel--necessary-cookies">
                        <h3>Strictly Necessary Cookies</h3>
                        <p>
                            These Cookies are necessary for core features of this site to operate properly. Because they are needed for the site’s operation, they are always set to “Active”. You may disable these by changing your browser settings, but this may affect how the website functions.
                        </p>

                    </div>
                    <div style="display: none;" class="manage-cookies-panel manage-cookies-panel--functional-cookies">
                        <h3>Functional Cookies</h3>
                        <p>These Cookies are used to provide a better user experience on the site, such as by measuring interactions with particular content or remembering your settings such as language or video playback preferences.
                        </p>
                        <input type="checkbox" name="functional-cookies">
                        <label for="functional-cookies">Accept functional cookies</label>
                        

                    </div>
                    <div style="display: none;" class="manage-cookies-panel manage-cookies-panel--performance-cookies">
                        <h3>Performance Cookies</h3>
                        <p>These Cookies allow us to analyse site usage in order to evaluate and improve its performance. They help us know how often you come to our site and when, how long you stay and any performance issues you experience whilst you are on our site.
                        </p>
                        <input type="checkbox" name="performance-cookies">
                        <label for="performance-cookies">Accept performance cookies</label>
                        

                    </div>

                    <div class="manage-cookies-panel manage-cookies-panel--targeting-cookies">
                        <h3>Targeting Cookies</h3>
                        <p>These Cookies are used by advertising companies to inform and serve personalised ads to your devices based on your interests. These Cookies also facilitate sharing information with social networks or recording your interactions with particular ads.
                        </p>
                        <input type="checkbox" name="targeting-cookies">
                        <label for="targeting-cookies">Accept Targeting cookies</label>
                        

                    </div>

                    
                </div>


            </div>
            <div class="manage-cookies-footer">
                <button class="submit-preferences">Submit preferences</button> <button class="accept-all-cookies">Accept all</button>
            </div>

        </div>
    </div>
</div>

<div class="manage-cookies-tab">
    <div class="manage-cookies-tab-inner">
        <button class="open-cookie-options">Cookie Preferences</button>
    </div>
</div>


<script>
//Main 
jQuery(document).ready(function()
{
    //Set manage cookie form values from cookies
    setOptionsFromStoredValues();

    //Toggle display of an overlay or
    //tab for the user to access options
    setBodyClass();

    //Handle nav tabbing in manage options
    jQuery('.nav-items a').click(function(e) {
        e.preventDefault();
        removeActive();
        var link = jQuery(this).attr('href').replace('#', '');
        addActive(link);
    });

    //Open cookie options click handler
    jQuery('.open-cookie-options').click(function(){
        openCookiesWrapper();
    });

    //Close cookie options click handler
    jQuery('.close-cookie-options').click(function(){
        closeCookiesWrapper();
    });

    //Submit cookie options click handler
    jQuery('.submit-preferences').click(function(){
        submitCookiePreferences();
    });

    //Accept all cookie options click handler
    jQuery('.accept-all-cookies').click(function(){
        setCookiePreferencesToAcceptAll();
    });
    
});

function openCookiesWrapper()
{
    jQuery('.manage-cookies-wrapper').addClass('active');
}

function closeCookiesWrapper()
{
    jQuery('.manage-cookies-wrapper').removeClass('active');
    setBodyClass();
}

//Fetches cookies by name
function getCookie(name) 
{
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
}

//Toggle display of overlay, or option button. 
function setBodyClass()
{
    var cookieOptions = getCookie('cookie_options');
    if (cookieOptions) {
        jQuery('body').addClass('cookie-options-set');
        jQuery('body').removeClass('cookie-options-not-set');
    } else {
        jQuery('body').addClass('cookie-options-not-set');
        jQuery('body').removeClass('cookie-options-set');
    }
}

//Restore cookie options in manage form from the cookie
function setOptionsFromStoredValues()
{
    var cookieOptions = getCookie('cookie_options');
    if (cookieOptions) {
        cookieOptions = JSON.parse(cookieOptions);
        setCookieOption('functional-cookies', cookieOptions.functional);
        setCookieOption('performance-cookies', cookieOptions.performance);
        setCookieOption('targeting-cookies', cookieOptions.targeting);
    }
}

//Fire google analytics one-time
function fireGA()
{
    console.log('Update tracking code here before deploy');
    // jQuery('<script src="https://www.googletagmanager.com/gtag/js?id=UA-114117736-1"><\/script>').appendTo(document.body);
    // console.log('Fire one-time tracking');
    // window.dataLayer = window.dataLayer || [];
    // function gtag(){dataLayer.push(arguments);}
    // gtag('js', new Date());
    // gtag('config', 'UA-114117736-1');
}

//Write cookie preferences as cookie
function submitCookiePreferences()
{
    var functionalCookieVal = getCookieOption('functional-cookies');
    var performanceCookieVal = getCookieOption('performance-cookies');
    var targetingCookieVal = getCookieOption('targeting-cookies');
    var cookies = {
        functional : functionalCookieVal,
        performance : performanceCookieVal,
        targeting : targetingCookieVal,
    };

    //If GA enable for first time then fire 
    if(targetingCookieVal == 1) {
        fireGA();
    }

    document.cookie = "cookie_options=" + JSON.stringify(cookies);
    closeCookiesWrapper();
}

//Get a cookie option value from the manage cookies form
function getCookieOption(name){

    if(jQuery('.cookie-notice input[name="'+name+'"]').prop('checked')) {
        return 1;
    }
    return 0;
}

//Set a cookie option value from the manage cookies form
function setCookieOption(name, checked){
    if(checked==1) {
        jQuery('.cookie-notice input[name="'+name+'"]').prop('checked', true)
    } else {
        jQuery('.cookie-notice input[name="'+name+'"]').prop('checked', false)
    }
}

//Set all options to true in manage cookies
function setCookiePreferencesToAcceptAll()
{
    setCookieOption('functional-cookies', 1);
    setCookieOption('performance-cookies', 1);
    setCookieOption('targeting-cookies', 1);
    submitCookiePreferences();
    closeCookiesWrapper();
}

//Adds active to  amange cookie option tab/panel
function addActive(link){
    jQuery('.manage-cookies-panel--' + link).addClass('active');
}

//Remove active from all mange cookie option tabs/panels
function removeActive(){
    jQuery('.manage-cookies-panel').each(function(){
        jQuery(this).removeClass('active');
    });
}
</script>