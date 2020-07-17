<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=6fe21523-b976-4ee9-8a82-f00c329c5837&lang=ru_RU" type="text/javascript"></script>
    <script src="info.js" type="text/javascript"></script>
    <script src="rfunk.js" type="text/javascript"></script>
    <script src="mfunk.js" type="text/javascript"></script>
    
    <script src="https://yastatic.net/s3/mapsapi-jslibs/heatmap/0.0.1/heatmap.min.js" type="text/javascript"></script>
    <body>
        <div id="map" style="width: 1000px; height: 800px">
        </div>
    </body>
 </head>

<?php
echo "Летняя практика";
?>

<script type="text/javascript">
    
    /* Работа с картой */
    ymaps.ready(['Heatmap']).then(function init() {
    var obj = json;
    var data = massData();
    var finaldata = [];
    var pk = -2;
    
    var myMap = new ymaps.Map('map', {
        center: [60.045775, 29.623283],
        zoom: 10,
    });
    myMap.controls.remove('searchControl');
    myMap.controls.remove('rulerControl');
    myMap.controls.remove('trafficControl');

    var field = new ymaps.GeoObject({
        // Описываем геометрию геообъекта.
        geometry: {
            // Тип геометрии - "Многоугольник".
            type: "Polygon",
            // Указываем координаты вершин многоугольника.
            coordinates: [
                // Координаты вершин внешнего контура.
                [
                    [59.977692607822, 29.376068115234],
                    [59.96051043886046, 29.5477294921875],
                    [59.93644042418626, 29.62188720703125],
                    [59.938504253195234, 29.698791503906254],
                    [59.938504253195234, 29.698791503906254],
                    [59.928871952236804, 29.77020263671875],
                    [59.91166445623312, 29.805908203125004],
                    [59.88893689676585, 29.91165161132813],
                    [59.882046686648536, 29.97482299804688],
                    [59.86412545369721, 30.02975463867188],
                    [59.86550435303646, 30.135498046875004],
                    [59.90340168857946, 30.206909179687504],
                    [59.94331935475679, 30.17532348632813],
                    [59.97494405975913, 30.20828247070313],
                    [59.97494405975913, 30.20828247070313],
                    [59.994179105518434, 30.01052856445313],
                    [60.007225093068755, 29.95834350585938],
                    [60.088132405328615, 29.91439819335938],
                    [60.10251038990616, 29.93637084960938],
                    [60.14218843384977, 29.92538452148438],
                    [60.16884161373975, 29.807281494140625],
                    [60.19069475310575, 29.61776733398438],
                    [60.182501529929304, 29.52713012695313],
                    [60.15790959006861, 29.443359375000004],
                    [60.07922860404502, 29.26345825195313]
                ],
            ],
            // Задаем правило заливки внутренних контуров по алгоритму "nonZero".
            fillRule: "nonZero"
        }
    }, {
        // Описываем опции геообъекта.
        // Цвет заливки.
        fillColor: '#00FF00',
        // Цвет обводки.
        strokeColor: '#0000FF',
        // Общая прозрачность (как для заливки, так и для обводки).
        opacity: 0.5,
        // Ширина обводки.
        strokeWidth: 5,
        // Стиль обводки.
        strokeStyle: 'shortdash'
    });
    myMap.geoObjects.add(field);
    
    /* Расчёт среднего значения */
    var avg = 0;
    for (var i = 0; i < obj.length; i++)
    {
        avg = avg + obj[i].Cells.Density
    }
    avg = avg / obj.length;

    /* Расчёт переменной градации */
    var col_grad = 0;
    var max_conc = 0;
    for (var i = 0; i < obj.length; i++)
    {
        if (max_conc < obj[i].Cells.Density)
        {
            max_conc = obj[i].Cells.Density;
        }
    }

    /* Метки опорных точек */
    for (var i = 0; i < obj.length; i++)
    {
        var placemark = new ymaps.Placemark([obj[i].Cells.geoData.coordinates[0], obj[i].Cells.geoData.coordinates[1]], {
        hintContent: obj[i].Cells.Density
        }, {
            iconLayout: 'default#image',
            iconImageHref: 'metka_new.png',
            iconImageSize: [10, 10],
            iconImageOffset: [0, 0]
        });
        myMap.geoObjects.add(placemark);
    }

    /////////////////////////////////////
    /* Расчётная функция (пространственная интерполяция) */
    var w = 0;
    var e = 0;

    for (i = 0; i < data.length; i++)
    {
        var ds = 0;

        for (j = 0; j < obj.length; j++)
        {
            ds = Math.sqrt(Math.pow((obj[j].Cells.geoData.coordinates[0] - data[i][0]), 2) + Math.pow((obj[j].Cells.geoData.coordinates[1] - data[i][1]), 2));
            w = w + (1 / Math.pow(ds, 2));
        }
        //alert ("Второй цикл");
        for (j = 0; j < obj.length; j++)
        {
            ds = Math.sqrt(Math.pow((obj[j].Cells.geoData.coordinates[0] - data[i][0]), 2) + Math.pow((obj[j].Cells.geoData.coordinates[1] - data[i][1]), 2));
            e = e + (obj[j].Cells.Density / Math.pow(ds, 2));
        }
        e = e / w;
        finaldata.push([ (data[i][0]), (data[i][1]), (e) ]);
        w = 0;
        e = 0;
    }
    /////////////////////////////////////
    
    /* Отображение отметок */
    /*for (i = 0; i < finaldata.length; i++)
    {
        var placemark = new ymaps.Placemark([ (finaldata[i][0]), (finaldata[i][1]) ], {
        hintContent: finaldata[i][2]
        }, {
            iconLayout: 'default#image',
            iconImageHref: 'circle.png',
            iconImageSize: [5, 5],
            iconImageOffset: [-3, -2]
        });
        myMap.geoObjects.add(placemark);
    }*/

    /* Отрисовка теплокарты */
    finaldata = poiConc((finaldata), avg, max_conc);
    objects = ymaps.geoQuery(finaldata);
    var objectsInside = objects.searchInside(field);

    var heatmap = new ymaps.Heatmap(objectsInside, {
        // Радиус влияния.
        radius: 18,
        // Нужно ли уменьшать пиксельный размер точек при уменьшении зума. False - не нужно.
        dissipating: false,
        // Прозрачность тепловой карты.
        opacity: 0.5,
        // Прозрачность у медианной по весу точки.
        intensityOfMidpoint: 0.1,
        // JSON описание градиента.
        gradient: {
            0.1: 'rgba(222, 235, 218, 1)',
            0.2: 'rgba(203, 230, 195, 1)',
            0.3: 'rgba(145, 219, 123, 1)',
            0.7: 'rgba(70, 181, 36, 1)',
            1.0: 'rgba(16, 69, 1, 1)'
        }
    });
    heatmap.setMap(myMap);    
    myMap.geoObjects.remove(field);
    });
    
</script>

