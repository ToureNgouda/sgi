$(function() {

    // Morris.Area({
        // element: 'morris-area-chart',
        // data: [{
            // period: '2017-12-10',
            // INFINITE: 56,
            // ODYSSEE: 34,
            // TOPKAPI: 45
        // }, {
            // period: '2017-12-11',
            // INFINITE: 21,
            // ODYSSEE: 43,
            // TOPKAPI: 76
        // }, {
            // period: '2017-12-10',
            // INFINITE: 23,
            // ODYSSEE: 21,
            // TOPKAPI: 38
        // }, {
            // period: '2017-12-12',
            // INFINITE: 52,
            // ODYSSEE: 65,
            // TOPKAPI: 48
        // }, {
            // period: '2017-12-13',
            // INFINITE: 32,
            // ODYSSEE: 43,
            // TOPKAPI: 56
        // }, {
            // period: '2017-12-14',
            // INFINITE: 45,
            // ODYSSEE: 5,
            // TOPKAPI: 32
        // }, {
            // period: '2017-12-15',
            // INFINITE: 23,
            // ODYSSEE: 37,
            // TOPKAPI: 15
        // }, {
            // period: '2017-12-16',
            // INFINITE: 15,
            // ODYSSEE: 59,
            // TOPKAPI: 51
        // }, {
            // period: '2017-12-17',
            // INFINITE: 10,
            // ODYSSEE: 44,
            // TOPKAPI: 20
        // }, {
            // period: '2017-12-18',
            // INFINITE: 43,
            // ODYSSEE: 57,
            // TOPKAPI: 17
		// }, {
            // period: '2017-12-19',
            // INFINITE: 53,
            // ODYSSEE: 37,
            // TOPKAPI: 24
        // }],
        // xkey: 'period',
        // ykeys: ['INFINITE', 'ODYSSEE', 'TOPKAPI'],
        // labels: ['INFINITE', 'ODYSSEE', 'TOPKAPI'],
        // pointSize: 2,
        // hideHover: 'auto',
        // resize: true
    // });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "INFINITE",
            value: 12
        }, {
            label: "ODYSSEE",
            value: 14
        }, {
            label: "TOPKAPI",
            value: 11
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2017-12-20',
            a: 32,
            b: 43,
            c: 56
        }, {
            y: '2017-12-21',
            a: 45,
            b: 5,
            c: 32
        }, {
            y: '2017-12-22',
            a: 23,
            b: 37,
            c: 15
        }, {
            y: '2017-12-23',
            a: 15,
            b: 59,
            c: 51
        }, {
            y: '2017-12-24',
            a: 10,
            b: 44,
            c: 20
        }, {
            y: '2017-12-25',
            a: 43,
            b: 57,
            c: 17
		}, {
            y: '2017-12-26',
            a: 53,
            b: 37,
            c: 24
        }],
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['INFINITE', 'ODYSSEE', 'TOPKAPI'],
        hideHover: 'auto',
        resize: true
    });
    
});
