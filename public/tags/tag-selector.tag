<tag-selector>
    <div class="back"></div>
    <form ref="form" class="card" onreset={ cancel } onsubmit={ submit }>
        <div class="card-section grid-y">
            <div class="contents cell medium-auto">
                <label each={ item in items } class={ opts.fullWidth ? 'full-width' : '' }>
                    <input type="checkbox" checked={ item.selected } onchange={ parent.elementChecked }>
                    <div class="content"><div data-is={ opts.component } item={ item }></div></div>
                </label>
            </div>
            <div class="toolbar cell medium-shrink">
                <button class="button align-right" type="reset"><i class="fa fa-remove"></i></button>
                <button class="button align-right" type="submit"><i class="fa fa-check"></i></button>
            </div>
        </div>
    </form>

    <style>
        :scope {
            width: 0;
            height: 0;
            margin: 0;
        }

        form {
            position: fixed;
            display: block;
            top: 1em;
            bottom: 1em;
            left: 50%;
            transform: translateX(-50%);
            max-width: 600px;
            width: 100%;
            z-index: 20;
        }

        .back {
            position: fixed;
            display: block;
            background: rgba( 0, 0, 0, 0.5 );
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 10;
        }

        .card {
            /*overflow: auto;*/
        }

        .card-section {
            position: relative;
        }

        .contents {
            overflow: auto;
            text-align: center;
            padding: 0.5em 1em 0.5em;
        }

        label {
            position: relative;
            display: inline-block;
            margin: 1em;
        }

        label.full-width {
            display: block;
            margin: 1em 0;
            width: 100%;
        }

        .content {
            cursor: pointer;
            border: 4px solid white;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]:checked + .content {
            border: 4px solid #23a3ba;
        }

        input[type="checkbox"]:checked + .content::after {
            content: "\002715";
            position: absolute;
            display: block;
            width: 1rem;
            height: 1rem;
            bottom: -0.5rem;
            right: -0.5rem;
            background: #23a3ba;
            color: white;
            line-height: 1;
        }

        .toolbar {
            text-align: right;
            border-top: 1px solid #e6e6e6;
        }
    </style>

    <script>
        this.items = [];

        let that = this;

        setItems( items ) {
            that.items = items;
            that.update();
        }

        this.on('mount', function() {
            opts.itemGetInitier( that );
        });

        function getItems() {
            let items = [];
            for( let i = 0; i < that.items.length; i++ ) {
                if( that.items[ i ].selected ) {
                    items.push( that.items[ i ] );
                }
            }
            return items;
        }

        elementChecked(e) {
            e.item.item.selected = e.target.checked;
        }

        submit(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            let items = getItems();
            this.unmount();
            opts.onSelected(items);
        }

        cancel(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            this.unmount();
            opts.onCancelled();
        }
    </script>
</tag-selector>