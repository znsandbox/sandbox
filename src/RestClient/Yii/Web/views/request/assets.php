<?php

/**
 * @var \yii\web\View $this
 */

$this->registerJs(<<<'JS'

if (window.localStorage) {
    var restHistoryTab = localStorage['restHistoryTab'] || 'collection';
    $('a[href="#' + restHistoryTab + '"]').tab('show');
    $('a[href="#collection"]').on('shown.bs.tab', function() {
        localStorage['restHistoryTab'] = 'collection';
    });
    $('a[href="#history"]').on('shown.bs.tab', function() {
        localStorage['restHistoryTab'] = 'history';
    });
}

JS
);
$this->registerJs(<<<'JS'

$('.request-lists a[data-toggle=tab]').on('shown.bs.tab', function() {
    $('#history-search').focus();
});

$('#history-search').keyup(function() {
    var needle = $(this).val().toLowerCase();
    $('.request-list li > a > .request-name').each(function() {
        var item = $(this).parents('li').first();
        if ($(this).text().toLowerCase().indexOf(needle) >= 0) {
            item.show();
        } else {
            item.hide();
        }
    });
});

JS
);
$this->registerCss(<<<'CSS'

.tab-content {
    margin-top: 15px;
}
.counter:before { content: "("; }
.counter:after{ content: ")"; }

CSS
);
$this->registerCss(<<<'CSS'

div.description-text {
    margin-bottom: 15px;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #eee;
}

ul.request-list,
ul.request-list ul {
    margin-bottom: 0;
    padding-left: 0;
    list-style: none;
}
ul.request-list {
    margin-bottom: 20px;
}
.request-list li {
    position: relative;
    display: block;
}
.request-list .request-list-group {
    padding: 10px 15px;
    margin-bottom: 5px;
    font-weight: bold;
    text-transform: uppercase;
    border-bottom: 2px solid #999;
}
.request-list li > a {
    position: relative;
    display: block;
    padding: 10px 15px;
    border-radius: 4px;
    background-color: #eee;
    margin-bottom: 5px;
}
.request-list li > a:hover,
.request-list li > a:focus {
    text-decoration: none;
    background-color: #ddd;
}
.request-list li.active > a {
    color: #fff;
    background-color: #337ab7;
}

.request-list li > .actions {
    display: none;
    position: absolute;
    top: 8px;
    right: 8px;
}
.request-list li:hover > .actions {
    display: inherit;
}
.request-list li > .actions > a {
    padding: 0 2px;
    font-size: 21px;
    font-weight: bold;
    line-height: 1;
    color: #000;
    text-decoration: none;
    opacity: .2;
}
.request-list li > .actions > a:hover {
    text-decoration: none;
    opacity: .5;
}

.request-list li > a:after {
    position: absolute;
    left: 0;
    /*top: 6px;
    bottom: 6px;*/
    width: 7px;
    border-right: 1px solid #fff;
    content: "";
    
    top: 0;
    bottom: 0;
    border-radius: 4px 0 0 4px;
}
/*.request-list  li.active > a:after,
.request-list li > a:hover:after,
.request-list li > a:focus:after {
    top: 0;
    bottom: 0;
    border-radius: 4px 0 0 4px;
}*/
.request-list li.success > a:after {
    background-color: #5cb85c;
}
.request-list li.info > a:after {
    background-color: #5bc0de;
}
.request-list li.warning > a:after {
    background-color: #f0ad4e;
}
.request-list li.danger > a:after {
    background-color: #d9534f;
}

.request-list .request-method {
    text-transform: uppercase;
    font-weight: bold;
}
.request-list .request-name {
    display: block;
    margin-right: 30px;
}
.request-list .request-description {
    display: block;
    font-size: 70%;
    color: #333;
}
.request-list .active .request-description {
    color: #fff;
}

CSS
);

$this->registerJs(<<<JS

if (window.localStorage) {
    var responseTab = localStorage['responseTab'] || 'response-body';
    $('a[href="#' + responseTab + '"]').tab('show');
    $('a[href="#response-body"]').on('shown.bs.tab', function() {
        localStorage['responseTab'] = 'response-body';
    });
    $('a[href="#response-headers"]').on('shown.bs.tab', function() {
        localStorage['responseTab'] = 'response-headers';
    });
}

JS
);
$this->registerCss(<<<'CSS'

.nav-tabs > li > .info {
    position: relative;
    display: block;
    padding: 10px 0 10px 15px;
    font-weight: bold;
}
.nav-tabs > li > .info .label {
    white-space: normal;
    font-size: 85%;
}
#response-headers tbody td {
    word-break: break-all;
}
#response-headers tbody th {
    width: 30%;
}
CSS
);

$this->registerJs(<<<'JS'

var inputSenderTab = $('#requestform-tab');
$('a[href="#request-query"]').on('shown.bs.tab', function() {
    inputSenderTab.val(1);
    $('#request-query').find(':text').first().focus();
});
$('a[href="#request-body"]').on('shown.bs.tab', function() {
    inputSenderTab.val(2);
    $('#request-body').find(':text').first().focus();
});
$('a[href="#request-headers"]').on('shown.bs.tab', function() {
    inputSenderTab.val(3);
    $('#request-headers').find(':text').first().focus();
});

JS
);
$this->registerCss(<<<'CSS'

.form-group-lg .input-group-addon {
    font-size: 18px;
}

CSS
);
