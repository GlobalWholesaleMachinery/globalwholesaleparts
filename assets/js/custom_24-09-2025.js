jQuery(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 200;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Read more";
    var lesstext = "Close";
    

    jQuery('.type-product p').each(function() {
        var content = jQuery(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext+ ' </span><span class="morecontent"><span>' + h + '</span>  <a href="" class="morelink">' + moretext + '</a></span>';
            jQuery(this).html(html);
        }
 
    });
 
    jQuery(".morelink").click(function(){
        if(jQuery(this).hasClass("less")) {
            jQuery(this).removeClass("less");
            jQuery(this).html(moretext);
        } else {
            jQuery(this).addClass("less");
            jQuery(this).html(lesstext);
        }
        jQuery(this).parent().prev().toggle();
        jQuery(this).prev().toggle();
        return false;
    });
});

jQuery( "form.header-login" ).on( "submit", function(e) {
 
  var dataString = jQuery(this).serialize();

  jQuery.ajax({
      type: "POST",
      url: "https://globalwholesaleparts.com/controller/submit-login.php",
      data: dataString,
      success: function (response) {
          var myArray = JSON.parse(response);
          console.log(myArray);
          if(myArray.status == 'success'){
              jQuery('#loginDropdown').trigger('click');
              jQuery('.loginDropdown-modal').removeClass('show');
              jQuery('#loginDropdown').hide();
              jQuery('.welcome-user').html('Welcome '+myArray.user);
              jQuery('#AccountDropdown').show();

              // jQuery.notify({
              //     message: "Login successfully."
              // },{
              //     // settings
              //     element: 'body',
              //     type: "success",
              //     placement: {
              //         from: "top",
              //         align: "right"
              //     },
              //     offset: 20,
              //     spacing: 10,
              //     z_index: 1031,
              //     timer: 3000,
              //     close: false
              // });

              window.location.href = "https://globalwholesaleparts.com/dashboard/";
          }
          if(myArray.status == 'success_affiliate'){
              jQuery('#loginDropdown').trigger('click');
              jQuery('.loginDropdown-modal').removeClass('show');
              jQuery('#loginDropdown').hide();
              jQuery('.welcome-user').html('Welcome '+myArray.user);
              jQuery('#AccountDropdown').show();

              window.location.href = "https://globalwholesaleparts.com/affiliate-products/";
          }

          if(myArray.status == 'incorrect'){
              if (myArray.role == 'dealer') {
                  jQuery('.dealer-alert').addClass('alert-danger');
                  jQuery('.dealer-alert').html('Incorrect Email/Username or Password!');
                  jQuery('.dealer-alert').show();
              }
              if (myArray.role == 'affiliate') {
                  jQuery('.affiliate-alert').addClass('alert-danger');
                  jQuery('.affiliate-alert').html('Incorrect Email/Username or Password!');
                  jQuery('.affiliate-alert').show();
              }
              if (myArray.role == 'customer') {
                  jQuery('.user-alert').addClass('alert-danger');
                  jQuery('.user-alert').html('Incorrect Email/Username or Password!');
                  jQuery('.user-alert').show();
              }
          }

          if(myArray.status == 'empty_email'){
              if (myArray.role == 'dealer') {
                  jQuery('.dealer-alert').addClass('alert-danger');
                  jQuery('.dealer-alert').html('Please enter Email Address/Username.');
                  jQuery('.dealer-alert').show();
              }
              if (myArray.role == 'affiliate') {
                  jQuery('.affiliate-alert').addClass('alert-danger');
                  jQuery('.affiliate-alert').html('Please enter Email Address/Username.');
                  jQuery('.affiliate-alert').show();
              }
              if (myArray.role == 'customer') {
                  jQuery('.user-alert').addClass('alert-danger');
                  jQuery('.user-alert').html('Please enter Email Address/Username.');
                  jQuery('.user-alert').show();
              }
          }

          if(myArray.status == 'empty_password'){
              if (myArray.role == 'dealer') {
                  jQuery('.dealer-alert').addClass('alert-danger');
                  jQuery('.dealer-alert').html('Please enter Password.');
                  jQuery('.dealer-alert').show();
              }
              if (myArray.role == 'affiliate') {
                  jQuery('.affiliate-alert').addClass('alert-danger');
                  jQuery('.affiliate-alert').html('Please enter Password.');
                  jQuery('.affiliate-alert').show();
              }
              if (myArray.role == 'customer') {
                  jQuery('.user-alert').addClass('alert-danger');
                  jQuery('.user-alert').html('Please enter Password.');
                  jQuery('.user-alert').show();
              }
          }

          if(myArray.status == 'not_active'){
              if (myArray.role == 'dealer') {
                  jQuery('.dealer-alert').addClass('alert-danger');
                  jQuery('.dealer-alert').html('Your account is under review, once the review is completed you will be notified through an email for login.');
                  jQuery('.dealer-alert').show();
              }
              if (myArray.role == 'affiliate') {
                  jQuery('.affiliate-alert').addClass('alert-danger');
                  jQuery('.affiliate-alert').html('Your account is under review, once the review is completed you will be notified through an email for login.');
                  jQuery('.affiliate-alert').show();
              }
              if (myArray.role == 'customer') {
                  jQuery('.user-alert').addClass('alert-danger');
                  jQuery('.user-alert').html('Your account is under review, once the review is completed you will be notified through an email for login.');
                  jQuery('.user-alert').show();
              }
          }
      }
  });

  e.preventDefault();
});


jQuery( "form.newsletter-subscription" ).on( "submit", function(e) {
 
  var dataString = jQuery(this).serialize();

  jQuery.ajax({
      type: "POST",
      url: "https://globalwholesaleparts.com/controller/submit-newsletter-subscription.php",
      data: dataString,
      success: function (response) {
          var myArray = JSON.parse(response);
          console.log(myArray);
          if(myArray.status == 'success'){
            jQuery('.newsletter-subscription')[0].reset();
              jQuery.notify({
                  message: "Your have been subscribed for newsletter successfully."
              },{
                  // settings
                  element: 'body',
                  type: "success",
                  placement: {
                      from: "top",
                      align: "right"
                  },
                  offset: 20,
                  spacing: 10,
                  z_index: 1031,
                  timer: 3000,
                  close: false
              });
          }

          if(myArray.status == 'incorrect'){
              jQuery.notify({
                  message: "Something went wrong, Please try again"
              },{
                  // settings
                  element: 'body',
                  type: "danger",
                  placement: {
                      from: "top",
                      align: "right"
                  },
                  offset: 20,
                  spacing: 10,
                  z_index: 1031,
                  timer: 3000,
                  close: false
              });
          }
      }
  });

  e.preventDefault();
});



/*
  Umair
  09-09-2025
  Below code is bstreeview
*/

/*! @preserve
 * bstreeview.js
 * Version: 1.2.1
 * Authors: Sami CHNITER <sami.chniter@gmail.com>
 * Copyright 2020
 * License: Apache License 2.0
 *
 * Project: https://github.com/chniter/bstreeview
 * Project: https://github.com/nhmvienna/bs5treeview (bootstrap 5)
 */
; (function ($, window, document, undefined) {
    "use strict";
    /**
     * Default bstreeview  options.
     */
    var pluginName = "bstreeview",
        defaults = {
            expandIcon: 'fa fa-angle-down fa-fw',
            collapseIcon: 'fa fa-angle-right fa-fw',
            expandClass: 'show',
            indent: 1.25,
            parentsMarginLeft: '1.25rem',
            openNodeLinkOnNewTab: true

        };
    /**
     * bstreeview HTML templates.
     */
    var templates = {
        treeview: '<div class="bstreeview"></div>',
        treeviewItem: '<div role="treeitem" class="list-group-item" data-bs-toggle="collapse"></div>',
        treeviewGroupItem: '<div role="group" class="list-group collapse" id="itemid"></div>',
        treeviewItemStateIcon: '<i class="state-icon"></i>',
        treeviewItemIcon: '<i class="item-icon"></i>'
    };
    /**
     * BsTreeview Plugin constructor.
     * @param {*} element
     * @param {*} options
     */
    function bstreeView(element, options) {
        this.element = element;
        this.itemIdPrefix = element.id + "-item-";
        this.mainId = element.id;
        this.settings = $.extend({}, defaults, options);
        this.init();
    }
    /**
     * Avoid plugin conflict.
     */
    $.extend(bstreeView.prototype, {
        /**
         * bstreeview intialize.
         */
        init: function () {
            this.tree = [];
            this.nodes = [];
            // Retrieve bstreeview Json Data.
            if (this.settings.data) {
                if (this.settings.data.isPrototypeOf(String)) {
                    this.settings.data = $.parseJSON(this.settings.data);
                }
                this.tree = $.extend(true, [], this.settings.data);
                delete this.settings.data;
            }
            // Set main bstreeview class to element.
            $(this.element).addClass('bstreeview');

            this.initData({ nodes: this.tree });
            var _this = this;
            this.build($(this.element), this.tree, 0);
            // Update angle icon on collapse
            $(this.element).on('click', '.list-group-item', function (e) {
                // navigate to href if present
                if (e.target.hasAttribute('href')) {
                    if (_this.settings.openNodeLinkOnNewTab) {
                        window.open(e.target.getAttribute('href'), '_blank');
                    }
                    else {
                        window.location = e.target.getAttribute('href');
                    }
                }
                else
                {
                    // Toggle the data-bs-target. Issue with Bootstrap toggle and dynamic code
                    $('#'+_this.mainId+' .list-group-item').removeClass('active');
                    // $(this).attr('aria-expanded',false);
                    $('.state-icon').removeClass(_this.settings.expandIcon).addClass(_this.settings.collapseIcon);
                    $($(this).attr("data-bs-target")).collapse('toggle');
                    $('.state-icon', this).toggleClass(_this.settings.expandIcon).toggleClass(_this.settings.collapseIcon);
                    $('.collapsed .state-icon').removeClass(_this.settings.expandIcon).addClass(_this.settings.collapseIcon);
                    $(this).addClass('active');
                    
                }
            });
        },
        /**
         * Initialize treeview Data.
         * @param {*} node
         */
        initData: function (node) {
            if (!node.nodes) return;
            var parent = node;
            var _this = this;
            $.each(node.nodes, function checkStates(index, node) {

                node.nodeId = _this.nodes.length;
                node.parentId = parent.nodeId;
                _this.nodes.push(node);

                if (node.nodes) {
                    _this.initData(node);
                }
            });
        },
        /**
         * Build treeview.
         * @param {*} parentElement
         * @param {*} nodes
         * @param {*} depth
         */
        build: function (parentElement, nodes, depth) {
            var _this = this;
            // Calculate item padding.
            var leftPadding = _this.settings.parentsMarginLeft;

            if (depth > 0) {
                leftPadding = (_this.settings.indent + depth * _this.settings.indent).toString() + "rem;";
            }
            depth += 1;
            // Add each node and sub-nodes.
            $.each(nodes, function addNodes(id, node) {
                // Main node element.
                var treeItem = $(templates.treeviewItem)
                    .attr('data-bs-target', "#" + _this.itemIdPrefix + node.nodeId)
                    .attr('data-bs-parent', "#" + _this.mainId)
                    .attr('style', 'padding-left:' + leftPadding)
                    .attr('aria-level', depth);
                // Set Expand and Collapse icones.
                if (node.nodes) {
                    var treeItemStateIcon = $(templates.treeviewItemStateIcon)
                        .addClass((node.expanded)?_this.settings.expandIcon:_this.settings.collapseIcon);
                    treeItem.append(treeItemStateIcon);
                }
                // set node icon if exist.
                if (node.icon) {
                    var treeItemIcon = $(templates.treeviewItemIcon)
                        .addClass(node.icon);
                    treeItem.append(treeItemIcon);
                }
                // Set node Text.
                treeItem.append(node.text);
                // Reset node href if present
                if (node.href) {
                    treeItem.attr('href', node.href);
                }
                // Add class to node if present
                if (node.class) {
                    treeItem.addClass(node.class);
                }
                // Add custom id to node if present
                if (node.id) {
                    treeItem.attr('id', node.id);
                }
                // Add custom id to node if present
                if (node.data_label && node.data_value) {
                    treeItem.attr(node.data_label, node.data_value);
                }
                if (node.data_label1 && node.data_value1) {
                    treeItem.attr(node.data_label1, node.data_value1);
                }
                if (node.data_label2 && node.data_value2) {
                    treeItem.attr(node.data_label2, node.data_value2);
                }
                if (node.data_label3 && node.data_value3) {
                    treeItem.attr(node.data_label3, node.data_value3);
                }
                // Attach node to parent.
                parentElement.append(treeItem);
                // Build child nodes.
                if (node.nodes) {
                    // Node group item.
                    var treeGroup = $(templates.treeviewGroupItem)
                        .attr('id', _this.itemIdPrefix + node.nodeId);
                    parentElement.append(treeGroup);
                    _this.build(treeGroup, node.nodes, depth);
                    if (node.expanded) {
                        treeGroup.addClass(_this.settings.expandClass);
                    }
                }
            });
        }
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" +
                    pluginName, new bstreeView(this, options));
            }
        });
    };
})(jQuery, window, document);
