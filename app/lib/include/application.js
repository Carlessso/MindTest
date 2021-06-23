loading = true;

Application = {};
Application.translation = {
    'en' : {
        'loading' : 'Loading'
    },
    'pt' : {
        'loading' : 'Carregando'
    },
    'es' : {
        'loading' : 'Cargando'
    }
};

Adianti.onClearDOM = function(){
	/* $(".select2-hidden-accessible").remove(); */
	$(".colorpicker-hidden").remove();
	$(".select2-display-none").remove();
	$(".tooltip.fade").remove();
	$(".select2-drop-mask").remove();
	/* $(".autocomplete-suggestions").remove(); */
	$(".datetimepicker").remove();
	$(".note-popover").remove();
	$(".dtp").remove();
	$("#window-resizer-tooltip").remove();
};


function showLoading() 
{ 
    if(loading)
    {
        __adianti_block_ui(Application.translation[Adianti.language]['loading']);
    }
}

Adianti.onBeforeLoad = function(url) 
{ 
    if (url.indexOf('&show_loading=false') > 0) {
        return true;
    }

    loading = true; 
    setTimeout(function(){showLoading()}, 400);
    
    if (url.indexOf('&static=1') == -1) {
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }
};

Adianti.onAfterLoad = function(url, data)
{ 
    loading = false; 
    __adianti_unblock_ui( true );
};

// set select2 language
$.fn.select2.defaults.set('language', $.fn.select2.amd.require("select2/i18n/pt"));


function add_question(question)
{
    Adianti.waitMessage = 'Carregando';__adianti_post_data('teste', 'class=QuestaoFormView&method=addQuestion');return false;
}

function replaceQuestionText(question)
{
    console.log(question.getAttribute('name'))
    Adianti.waitMessage = 'Carregando';__adianti_post_data('teste', 'class=QuestaoFormView&method=replaceTextQuestion&value=' + question.getAttribute('name'));return false;
}

function replaceQuestionSelect(question)
{
    Adianti.waitMessage = 'Carregando';__adianti_post_data('teste', 'class=ProvaFormView&method=replaceSelectQuestion&value=' + question.getAttribute('name'));return false;
}

function showOnClick()
{
    var content = $('.panel-top-form');

    window.scrollTo(0, 0);
    
    if( content.css('display') == 'none' )
    {
        content.show(200);
    }
    else
    {
        content.hide(200);
    }
}

function change_page(id_question, action)
{
    __adianti_load_page(action);

    var url = 'index.php?class=ProvaFormView&';
}

function change_modalidade()
{
    var professor        = $('#modalidade_professor');
    var provas_professor = $('#div_provas_professor');
    var aluno            = $('#modalidade_aluno');
    var provas_aluno     = $('#div_provas_aluno');

    if( professor.css('display') == 'none' )
    {
        professor.show();
        provas_professor.show();
        aluno.hide();
        provas_aluno.hide();
    }
    else
    {
        professor.hide();
        provas_professor.hide();
        aluno.show();
        provas_aluno.show();
    }
}



function getLocation()
{
    if (navigator.geolocation) 
    {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
    else 
    { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

  function showPosition(position) {
    let latitude    = position.coords.latitude;
    let longitude   =  position.coords.longitude;

    console.log(latitude, longitude);
  }