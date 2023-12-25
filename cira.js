var obj = [{
    "name": "B6",
    "x": 230,
    "y": 268
},
{
    "name": "no9",
    "x": 551,
    "y": 258
},
{
    "name": "no9",
    "x": 59,
    "y": 257
},
{
    "name": "BKK",
    "x": 315,
    "y": 378
},
{
    "name": "no1",
    "x": 485,
    "y": 260
},
{
    "name": "C3",
    "x": 144,
    "y": 264
},
{
    "name": "no2",
    "x": 334,
    "y": 258
},
{
    "name": "no0",
    "x": 425,
    "y": 259
}];
var ansArr = []
var lastA = obj.length

function compareNumbers(a, b) {
    return a - b;
}

for (var i = 0; i < lastA; i++) {
    ansArr.push(obj[i].x)
}
ansArr.sort(compareNumbers)
console.log(ansArr)