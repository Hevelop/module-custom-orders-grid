define([
    'Magento_Ui/js/grid/columns/column'
  ],
  function (Column) {
    'use strict';

    return Column.extend({
      defaults: {
        bodyTmpl: 'Hevelop_CustomOrdersGrid/grid/cells/flag-order',

      },

      getFieldHandler: function (record) {
        return false;
      }
    });
  }
);