var postalCodes;
var bylineLength;
$(document).ready(function(){
    var now = new Date();
    
    // Init Tooltip
    $('form .icon-info-sign').tooltip({
        animation : true,
        placement : 'right',
        title: 'Title'
    });
    
    //Init Datepicker
    $('.datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        showAnim: 'slideDown',
        dateFormat: "dd/mm/yy" + " " + now.getHours() + ":00"
    });
    $('#endTime .datepicker').datepicker({
        dateFormat: "dd/mm/yy" + " " + now.getHours() + ":00"
    });

    //Show form inputs in color
    $('form .control-group .controls').each(function(){
        var fieldError = $(this).find('.help-inline');
        if(fieldError.hasClass('help-inline')){
            $(this).parent().addClass('error');
        } else {
        //TODO Show input in green if ok?
        //            $(this).parent().addClass('success');
        }
    });
    
    //Init Textarea Html Editor
    nicEditors.allTextAreas({
        iconsPath : '../img/nicEditorIcons.gif',
        buttonList : ['bold','italic','underline','ul','ol']
    });
    
    //Remove Additional <br> tags from textareas
    $('form .nicEdit-main').each(function(){
        var textField = $(this).html().replace('<br>', '');
        $(this).html(textField);
    });
    
    //Add autocomplete to location postal code field
    $.ajax({
        url:'/geolocation/get-locations',
        type: 'post',
        data: {},
        success:function(result){
            initAutocompletePostalCodeField(result);
        }
    });
    
    //Add letter count to Byline field
    bylineLength = parseInt($('#byline').attr('maxLength'));
    var bylineCounter = '<span id="byline-counter"></span>';
    $('form #byline').parent().append(bylineCounter);
    $('form #byline').keyup(function(){
        $('#byline-counter').html(bylineLength - $(this).val().length)
    });
    
    $("select").change(function(){
        var statusId = $(this).val();
        var applicationId = $(this).attr('id');
        $.ajax({
            url:'/job-application/change-status',
            type: 'post',
            data: {
                'statusId': statusId,
                'applicationId': applicationId
            },
            success:function(result){
                if(result == true){
                    $('#'+applicationId+' .confirmed-application-status-update').show();
                    setTimeout('hideConfirm()', 2000);
                }
            }
        });
    });
    var currentStars = 0;
    var container = '';
    $('.star-rating').mouseover(function(){
        container = $(this).parent();
        container.children().each(function(){
            if($(this).hasClass('full')){
                currentStars++;
            } 
        });
        var hoveredStar = $(this).index()+1;
        setFullStars(container, hoveredStar);
        
    });
    $('.star-rating').click(function(){
        var clickedStar = $(this).index()+1;
        var applicationId = $(this).parent().parent().attr('id');
        setFullStars(container, currentStars);
        $.ajax({
            url:'/job-application/rate-application',
            type: 'post',
            data: {
                'clickedStar' : clickedStar,
                'applicationId' : applicationId
            },
            success:function(result){
                result = true;
                if(result == true){
                    currentStars = clickedStar;
                }
            }
        });
        currentStars = clickedStar;
    });
    $('.star-rating').mouseout(function(){
        setFullStars(container, currentStars);
        currentStars = 0;
    });
    
});

function setFullStars(element, nr)
{
    element.children().each(function(){
        if($(this).index() < nr){
            $(this).removeClass('empty').addClass('full');
        } else{
            $(this).removeClass('full').addClass('empty');
        }
    });
}

function initAutocompletePostalCodeField(data){
    $('form #locationPostalCode').typeahead({
        source : data,
        items  : 10
    });
}

function hideConfirm()
{
    $('.confirmed-application-status-update').hide();
}