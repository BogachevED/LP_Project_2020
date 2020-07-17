src="rfunk.js"

var mX = [];
var mY = [];
var dataX_temp = [];
var dataY_temp = [];

var x1 = 60.0370350000000;
var y1 = 29.6720400000000;

var x2 = 59.8606590000000;
var y2 = 30.2600090000000;

var stepX = (x2 - x1) / 25;
//stepX = roundPlus(stepX, 12);
var stepY = (y2 - y1) / 25;
//stepY = roundPlus(stepY, 12);

function aldouble() 
{
    alert("Шаг X " + stepX);
    alert("Шаг Y " + stepY);
    return 0;
}

function msfX()
{
    var z = x1;
    dataX_temp.push(z);
    for (var i = 0; i < 24; i++)
    {
        z = z + stepX;
        dataX_temp.push(z);
    }
    return dataX_temp;
}

function msfY()
{
    var z = y1;
    dataY_temp.push(z);
    for (var j = 0; j < 24; j++)
    {
        z = z + stepY;
        dataY_temp.push(z);
    }
    
    return dataY_temp;
}

function massData()
{
    var bigData = [];
    var dataX_temp2 = msfX();
    var dataY_temp2 = msfY();

    for (i = 0; i < dataX_temp2.length; i++)
    {
        for (j = 0; j < dataY_temp2.length; j++)
        {
            bigData.push([ (dataX_temp2[i]), (dataY_temp2[j]) ]);
        }       
    }
    return bigData;
}

function poiConc(finaldata, avg, max_conc)
{
    var col_step = ((max_conc - avg) / 10);
    var data_temp = [];
    for (var i = 0; i < finaldata.length; i++)
    {
        if (finaldata[i][2] < avg)
        {
            data_temp.push( 
                {
                    type: "Point",
                    coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                } 
            );
        }
        else
        {
            if ((finaldata[i][2] >= avg) && (finaldata[i][2] < (avg + col_step)))
            {
                for (var j = 0; j < 4; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step)) && (finaldata[i][2] < (avg + col_step * 2)) )
            {
                for (var j = 0; j < 8; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 2)) && (finaldata[i][2] < (avg + col_step * 3)) )
            {
                for (var j = 0; j < 10; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 3)) && (finaldata[i][2] < (avg + col_step * 4)) )
            {
                for (var j = 0; j < 12; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 4)) && (finaldata[i][2] < (avg + col_step * 5)) )
            {
                for (var j = 0; j < 14; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 5)) && (finaldata[i][2] < (avg + col_step * 6)) )
            {
                for (var j = 0; j < 16; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 6)) && (finaldata[i][2] < (avg + col_step * 7)) )
            {
                for (var j = 0; j < 32; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 7)) && (finaldata[i][2] < (avg + col_step * 8)) )
            {
                for (var j = 0; j < 64; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 8)) && (finaldata[i][2] < (avg + col_step * 9)) )
            {
                for (var j = 0; j < 128; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
            else if ( (finaldata[i][2] >= (avg + col_step * 9)) && (finaldata[i][2] < (avg + col_step * 10)) )
            {
                for (var j = 0; j < 256; j++)
                {
                    data_temp.push( 
                        {
                            type: "Point",
                            coordinates: [(finaldata[i][0]), (finaldata[i][1])]
                        } 
                    );
                }
            }
        }
    }
    return data_temp;
}