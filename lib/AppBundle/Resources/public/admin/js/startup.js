document.addEventListener(pimcore.events.postOpenAsset, (e) => {
    if (e.detail.asset.data.mimetype === 'text/csv') {
        e.detail.asset.toolbar.add({
            text: t('import-csv'),
            iconCls: 'pimcore_icon_csv',
            scale: 'small',
            handler: function (obj) {
                Ext.Ajax.request({
                    url: Routing.generate('imported_app_csv'),
                    method: "POST",
                    params: {
                        id: obj.id
                    },
                    success: function (response) {
                        let responseText =Ext.decode(response.responseText);
                        pimcore.helpers.showNotification(t("import"), responseText.message, responseText.type);
                    }
                });

            }.bind(this, e.detail.asset)
        });
        pimcore.layout.refresh();
    }
});