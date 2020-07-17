function roundPlus(x, n) 
{
    if(isNaN(x) || isNaN(n)) {
        return false;
    }
    else {
        var m = Math.pow(10,n);
        return Math.round(x*m)/m;
    }   
}