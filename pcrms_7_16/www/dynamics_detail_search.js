

var human_chrom = ["chr1", "chr2","chr3", "chr4",
"chr5", "chr6","chr7", "chr8","chr9", "chr10",
"chr11", "chr12","chr13", "chr14","chr15", "chr16",
"chr17", "chr18","chr19", "chr20","chr21", "chr22",
"chrX", "chrY"];


var mouse_chrom = ["chr1", "chr2","chr3", "chr4",
"chr5", "chr6","chr7", "chr8","chr9", "chr10",
"chr11", "chr12","chr13", "chr14","chr15", "chr16",
"chr17", "chr18","chr19", "chr20",
"chrX", "chrY"];


var ce_chrom = ["chr1", "chr2","chr3", "chr4","chr5"];



var chromosomes={
    1:human_chrom,
    2:mouse_chrom,
    3:ce_chrom
}

// getting the main and sub menus


var genome= document.getElementById('genome_id');
var chr = document.getElementById('chr_id');


// Trigger the Event when main menu change occurs

genome.addEventListener('change',function(){

// getting a selected option

var selected_option = chromosomes[this.value];


// removing the sub menu options using while loop

while(chr.options.length > 0){

chr.options.remove(0);

}


//conver the selected object into array and create a options for each array elements 
//using Option constructor  it will create html element with the given value and innerText



Array.from(selected_option).forEach(function(el){

    let option  = new Option(el, el);

    //append the child option in sub menu

    chr.appendChild(option);

});

});


genome.addEventListener('click',function(){

    // getting a selected option
    
    var selected_option = chromosomes[this.value];
    
    
    // removing the sub menu options using while loop
    
    while(chr.options.length > 0){
    
    chr.options.remove(0);
    
    }
    
    
    //conver the selected object into array and create a options for each array elements 
    //using Option constructor  it will create html element with the given value and innerText
    
    
    
    Array.from(selected_option).forEach(function(el){
    
        let option  = new Option(el, el);
    
        //append the child option in sub menu
    
        chr.appendChild(option);
    
    });
    
});

genome.addEventListener('mouseover',function(){

    // getting a selected option
    
    var selected_option = chromosomes[this.value];
    
    
    // removing the sub menu options using while loop
    
    while(chr.options.length > 0){
    
    chr.options.remove(0);
    
    }
    
    
    //conver the selected object into array and create a options for each array elements 
    //using Option constructor  it will create html element with the given value and innerText
    
    
    
    Array.from(selected_option).forEach(function(el){
    
        let option  = new Option(el, el);
    
        //append the child option in sub menu
    
        chr.appendChild(option);
    
    });
    
});

//genome.addEventListener('change', list_chromosomes);
//genome.addEventListener('click', list_chromosomes);