require('./cms/products');
require('./dependencies/trumbowyg');
require('./dependencies/trumbowyg.colors');
require('./dependencies/trumbowyg.fontsize');
require('./dependencies/trumbowyg.fontfamily');
require('./dependencies/trumbowyg.cleanpaste');

const XLSX = require('xlsx');
const Papa = require('papaparse');

$.trumbowyg.svgPath = '/css/icons.svg';
const trumbowygConfig = {
  btns: [
    ['viewHTML'],
    ['strong', 'em', 'del', 'underline'],
    ['foreColor', 'backColor'],
    ['fontfamily'],
    ['fontsize'],
    ['link'],
    ['insertImage'],
    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
    ['unorderedList', 'orderedList'],
    ['removeformat'],
    ['fullscreen']
  ],
  autogrow: true,
  autogrowOnEnter: true,
  plugins: {
    cleanPaste: {},
    colors: {
      colorList: [
        'B61B27', 'FFF', 'EFF0F1', '656565'
      ]
    },
    fontfamily: {
      fontList: [
          {name: 'Myriad Pro', family: '"Myriad Pro", "Helvetica Neue", Helvetica, Arial, sans-serif'},
          {name: 'Nexa', family: 'Nexa, "Helvetica Neue", Helvetica, Arial, sans-serif'}
      ]
   },
   fontsize: {
     allowCustomSize: false,
     sizeList: [
        '0.9rem',
        '1.0rem',
        '1.1rem',
        '1.2rem',
        '1.3rem',
        '1.4rem',
        '1.5rem',
        '1.6rem',
        '1.7rem',
      ],
    },
  }
};
$('textarea.editor').trumbowyg(trumbowygConfig);
window.trumbowygConfig = trumbowygConfig;

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$('.gallery').on('click', '.deletable a.btn-danger', function () {
  var url = $('.gallery').attr('data-ref');
  var delete_url = $('.gallery').attr('delete-ref');

  var reload = function () {
    $.ajax({
      url: url,
      success: function (result) {
        var html = $('<div>')
        for (let row of result) {
          var a = $('<a href="javascript:;" class="btn btn-danger" data-ref="' + delete_url.replace('__ID__', row.id) + '"></a>')
          a.append('<span class="fa fa-trash"></span>')

          var deletable = $('<div class="deletable"></div>')
          deletable.append('<img src="/' + row.image + '" width="100%"></div>')
          deletable.append(a)

          html.append(deletable)
        }

        $('.gallery').html(html)
      }
    })
  }

  $.ajax({
    url: $(this).attr('data-ref'),
    method: 'DELETE',
    success: reload
  })
});

$('#import_products_xlsx').on('change', function (e) {
  let form = $(this).closest('form');
  let input = $(form).children('input#data');

  let files = e.target.files, f = files[0];
  let reader = new FileReader();
  reader.onload = function (e) {
    let data = new Uint8Array(e.target.result);
    let workbook = XLSX.read(data, { type: 'array' });
    let sheetname = workbook.SheetNames[0];
    let sheet = workbook.Sheets[sheetname];
    let result = parseCSV(XLSX.utils.sheet_to_csv(sheet));
    input.val(JSON.stringify(result));
    form.submit();
  };
  reader.readAsArrayBuffer(f);

  const parseCSV = (csv) => {
    let lines = Papa.parse(csv).data;
    let result = {};
    let categories = lines.shift().map(row => row.trim());
    categories.splice(0, 2);
    let previousCategory = categories[0];

    categories.forEach((category, i) => {
      if (category && category.length > 0) {
        previousCategory = category;
      } else {
        categories[i] = previousCategory;
      }
    });

    let models = lines.shift().map(row => row.trim());
    models.splice(0, 2);

    let sections = [];

    for (let line of lines) {
      if (lines.length < 2) continue;
      let section = (line.shift() || '').trim();
      let field = (line.shift() || '').trim();

      if (!sections.includes(section)) {
        sections.push(section);
      }

      const sectionIndex = sections.indexOf(section);

      for (let i in models) {
        let model = models[i];
        if (!line[i] || line[i].length === 0) continue;
        result[model] = result[model] || { category: categories[i], specs: {} };
        result[model].specs[sectionIndex] = result[model].specs[sectionIndex] || { id: sectionIndex, section, data: [] };
        const row = {
          id: result[model].specs[sectionIndex].data.length,
          field,
          value: line[i].trim(),
        };
        result[model].specs[sectionIndex].data.push(row);
      }
    }

    return result;
  }
});

$('#import_pricing_xlsx').on('change', function (e) {
  let form = $(this).closest('form');
  let input = $(form).children('input#data');

  let files = e.target.files, f = files[0];
  let reader = new FileReader();
  reader.onload = function (e) {
    let data = new Uint8Array(e.target.result);
    let workbook = XLSX.read(data, { type: 'array' });
    let sheetname = workbook.SheetNames[0];
    let sheet = workbook.Sheets[sheetname];
    let result = parseCSV(XLSX.utils.sheet_to_csv(sheet));
    input.val(JSON.stringify(result));
    form.submit();
  };
  reader.readAsArrayBuffer(f);

  const parseCSV = (csv) => {
    let lines = Papa.parse(csv).data;
    let result = {};
    let spot_price = lines[1].slice(1);
    let fee = lines[2].slice(1);
    let currency = lines[3].slice(1);
    let models = lines[0].slice(1);
    let statusok = lines[4].slice(1);

    models.forEach((model, id) => {
      result[model] = [
        {
          id,
          field: 'Contado',
          value: spot_price[id],
        },
        {
          id,
          field: 'Cuotas desde',
          value: fee[id],
        },
        {
          id,
          field: 'Moneda',
          value: currency[id],
        },
        {
          id,
          field: 'Status',
          value: statusok[id],
        }
      ];
      console.log(model);
    })
    // return false;
    return result;
  }
});
