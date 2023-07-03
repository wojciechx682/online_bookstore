<html>
    <head>

    </head>
<body>

<script>

    let tab = ["0", "1", "2"];

    let people = [
        {
            name: "Adam",
            age: 25
        },
        {
            name: "John",
            age: 38
        },
        {
            name: "Mike",
            age: 22
        },
        {
            name: "Patric",
            age: 42
        },
    ]

    console.log("\n people -> ", people);
    console.log("\n people -> ", typeof people);

    console.log("\n tab -> ", tab);
    console.log("\n tab -> ", typeof tab);

   /* function priceRange(person) {
        return (person.age < 30);
    }*/


    // Filtrowanie tablicy ;

    result = [];

    result = people.filter(function(person) {
        return (person.age > 30);
    });

    console.log("\n result -> ", result);
    console.log("\n result -> ", typeof result);

    array = [];

    /*for(let i = 0; i < people.length; i++) {
        if(people[i].age < 30) {
            array.push(people[i]);
        }
    }*/

    people.forEach(function(person) {
        if(person.age > 30){
            array.push(person);
        }
    });


    console.log("\n array -> ", array);
    console.log("\n array -> ", typeof array);

    ///////////////////////////////////////////////////////////////////////////////
    let div = document.createElement("div");
    let p = document.createElement("p");
    p.innerHTML = "akapit 1";

    let p2 = document.createElement("p");
    p2.innerHTML = "akapit 2";

    let p3 = document.createElement("p");
    p3.innerHTML = "akapit 3";

    let tab2 = [];

    /*for (let i = 0; i < 3; i++) {
        tab2[i] = i;
    }*/

    div.appendChild(p);

    /*console.log(Array.from('foo'));
    // Expected output: Array ["f", "o", "o"]

    console.log(Array.from([1, 2, 3], x => x + x));
    // Expected output: Array [2, 4, 6]*/

    console.log("\n div -> ", div);

    console.log(Array.from(p));




    tab2 = [p, p2, p3];

    console.log("\n tab2 -> ", tab2);

</script>



</body>
</html>