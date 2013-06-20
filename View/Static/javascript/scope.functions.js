/**
 * Created with JetBrains PhpStorm.
 * User: dylan
 * Date: 21-5-13
 * Time: 12:39
 * To change this template use File | Settings | File Templates.
 */
function clickDay() {
    setCookie('scope', 1);
}

function clickWeek() {
    setCookie('scope', 7);
}

function clickMonth() {
   var date = new Date();
   setCookie('scope', new Date(date.getYear(), date.getMonth(), 0).getDate());
}

function setCookie(name, value) {
    document.cookie = name + "=" + value;
}