var tags        = $('.tags'),
    tagList     = tags.find('li'),
    tagSelect   = $('.tag-select'),
    tagInput    = $('.tag-input'),
    tagsData    = $('[data-tags]'),
    tagBtn      = $('.insert-tag'),
    tagsJson    = [];

!function ($) {
    "use strict";
    var Posts = function () {
        },
        $self,
        $app;

    Posts.prototype.initTags = function () {
        $.each(tagList, function (index) {
            var $this = $(this);
            $self.pushTags($this.data('name'));
        });

        tagBtn.on('click', function () {
            if (tagInput.val() != '') {
                $.each($self.split(tagInput.val()), function (index, value) {
                    if (tagsJson.indexOf(value) === -1 && value != '') {
                        $self.pushTags(value, true);
                    }
                });
                tagInput.val('');
            }
        });

        tags.on('click', 'li span', function () {
            var li   = $(this).closest('li'),
                name = li.data('name');

            tagsJson.splice(tagsJson.indexOf(name), 1)

            li.remove();
            tagSelect.find('option[value="' + name + '"]').remove();
        });

        tagInput.on("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        }).autocomplete(
            {
                minLength: 0,
                maxResults: 10,
                source: function (request, response) {
                    var results = $.ui.autocomplete.filter(tagsData.data('tags'), $self.extractLast(request.term));
                    response(results.slice(0, this.options.maxResults));

                },
                focus: function () {
                    return false;
                },
                select: function (event, ui) {
                    var terms = $self.split(this.value);
                    terms.pop();
                    terms.push(ui.item.value);
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }
            });
    }

    Posts.prototype.initFileManager = function () {
        $('.manager-image').on("click", function (e) {
            e.preventDefault();

            $(this).manager(
                {
                    manager: manager,
                    tools: true,
                    multiple: true,
                    data: {type: 'image'},
                    complete: function (data) {
                        if (data.length) {
                            $.each(data, function (index, val) {
                                var orientation = $app.imageOrientation(val.url);
                                $app.filesInput.append('<option value="' + val.path + '" selected>' + val.path + '</option>');
                                $app.grid.append('<div class="item new"><img src="' + val.url + '" data-orientation="' + orientation + '"></div>');
                            });
                        }
                    }
                }
            );
        });
    }

    Posts.prototype.pushTags = function (name, push_li) {
        if (push_li == true) {
            tags.append('<li class="list-inline-item" data-name="' + name + '"><span></span>' + name + '</li>');
        }
        tagSelect.append('<option value="' + name + '" selected>' + name + '</option>');
        tagsJson.push(name);
    }

    Posts.prototype.split = function (val) {
        return val.split(/,\s*/);
    }

    Posts.prototype.extractLast = function (term) {
        return $self.split(term).pop();
    }

    Posts.prototype.init = function () {

        $self = this;
        $app  = $.App;

        this.initTags();
        this.initFileManager();

    }

    //init
    $.Posts = new Posts, $.Posts.Constructor = Posts
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";
        $.Posts.init();
    }(window.jQuery);





