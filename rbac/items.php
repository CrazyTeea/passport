<?php
return [
    'root' => [
        'type' => 1,
        'children' => [
            '/*',
        ],
    ],
    '/*' => [
        'type' => 2,
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            '/app/passport/*',
            '/app/organizations/*',
            '/app/objects/*',
            '/app/documents/*',
            '/api/user/*',
            '/api/regions/*',
            '/api/organizations/*',
            '/api/objects/*',
            '/app/manual/*',
            '/app/manual/index',
            '/app/admin/index',
            '/app/admin/*',
            '/admin/menu/*',
            '/admin/default/*',
            '/admin/assignment/*',
            '/admin/permission/*',
            '/admin/role/*',
            '/admin/rule/*',
            '/admin/user/*',
        ],
    ],
    'user' => [
        'type' => 1,
        'children' => [
            '/app/passport/*',
            '/app/organizations/*',
            '/app/objects/*',
            '/app/documents/*',
            '/api/user/*',
            '/api/regions/*',
            '/api/organizations/*',
            '/api/objects/*',
            '/app/manual/*',
            '/app/manual/index',
        ],
    ],
    '/app/passport/*' => [
        'type' => 2,
    ],
    '/app/organizations/*' => [
        'type' => 2,
    ],
    '/app/objects/*' => [
        'type' => 2,
    ],
    '/app/documents/*' => [
        'type' => 2,
    ],
    '/api/user/*' => [
        'type' => 2,
    ],
    '/api/regions/*' => [
        'type' => 2,
    ],
    '/api/organizations/*' => [
        'type' => 2,
    ],
    '/api/objects/*' => [
        'type' => 2,
    ],
    '/app/manual/*' => [
        'type' => 2,
    ],
    '/app/manual/index' => [
        'type' => 2,
    ],
    '/app/admin/index' => [
        'type' => 2,
    ],
    '/app/admin/*' => [
        'type' => 2,
    ],
    '/admin/assignment/index' => [
        'type' => 2,
    ],
    '/admin/assignment/view' => [
        'type' => 2,
    ],
    '/admin/assignment/assign' => [
        'type' => 2,
    ],
    '/admin/assignment/revoke' => [
        'type' => 2,
    ],
    '/admin/assignment/*' => [
        'type' => 2,
    ],
    '/admin/default/index' => [
        'type' => 2,
    ],
    '/admin/default/*' => [
        'type' => 2,
    ],
    '/admin/menu/index' => [
        'type' => 2,
    ],
    '/admin/menu/view' => [
        'type' => 2,
    ],
    '/admin/menu/create' => [
        'type' => 2,
    ],
    '/admin/menu/update' => [
        'type' => 2,
    ],
    '/admin/menu/delete' => [
        'type' => 2,
    ],
    '/admin/menu/*' => [
        'type' => 2,
    ],
    '/admin/permission/index' => [
        'type' => 2,
    ],
    '/admin/permission/view' => [
        'type' => 2,
    ],
    '/admin/permission/create' => [
        'type' => 2,
    ],
    '/admin/permission/update' => [
        'type' => 2,
    ],
    '/admin/permission/delete' => [
        'type' => 2,
    ],
    '/admin/permission/assign' => [
        'type' => 2,
    ],
    '/admin/permission/remove' => [
        'type' => 2,
    ],
    '/admin/permission/*' => [
        'type' => 2,
    ],
    '/admin/role/index' => [
        'type' => 2,
    ],
    '/admin/role/view' => [
        'type' => 2,
    ],
    '/admin/role/create' => [
        'type' => 2,
    ],
    '/admin/role/update' => [
        'type' => 2,
    ],
    '/admin/role/delete' => [
        'type' => 2,
    ],
    '/admin/role/assign' => [
        'type' => 2,
    ],
    '/admin/role/remove' => [
        'type' => 2,
    ],
    '/admin/role/*' => [
        'type' => 2,
    ],
    '/admin/route/index' => [
        'type' => 2,
    ],
    '/admin/route/create' => [
        'type' => 2,
    ],
    '/admin/route/assign' => [
        'type' => 2,
    ],
    '/admin/route/remove' => [
        'type' => 2,
    ],
    '/admin/route/refresh' => [
        'type' => 2,
    ],
    '/admin/route/*' => [
        'type' => 2,
    ],
    '/admin/rule/index' => [
        'type' => 2,
    ],
    '/admin/rule/view' => [
        'type' => 2,
    ],
    '/admin/rule/create' => [
        'type' => 2,
    ],
    '/admin/rule/update' => [
        'type' => 2,
    ],
    '/admin/rule/delete' => [
        'type' => 2,
    ],
    '/admin/rule/*' => [
        'type' => 2,
    ],
    '/admin/user/index' => [
        'type' => 2,
    ],
    '/admin/user/view' => [
        'type' => 2,
    ],
    '/admin/user/delete' => [
        'type' => 2,
    ],
    '/admin/user/login' => [
        'type' => 2,
    ],
    '/admin/user/logout' => [
        'type' => 2,
    ],
    '/admin/user/signup' => [
        'type' => 2,
    ],
    '/admin/user/request-password-reset' => [
        'type' => 2,
    ],
    '/admin/user/reset-password' => [
        'type' => 2,
    ],
    '/admin/user/change-password' => [
        'type' => 2,
    ],
    '/admin/user/activate' => [
        'type' => 2,
    ],
    '/admin/user/*' => [
        'type' => 2,
    ],
    '/admin/*' => [
        'type' => 2,
    ],
    '/debug/default/db-explain' => [
        'type' => 2,
    ],
    '/debug/default/index' => [
        'type' => 2,
    ],
    '/debug/default/view' => [
        'type' => 2,
    ],
    '/debug/default/toolbar' => [
        'type' => 2,
    ],
    '/debug/default/download-mail' => [
        'type' => 2,
    ],
    '/debug/default/*' => [
        'type' => 2,
    ],
    '/debug/user/set-identity' => [
        'type' => 2,
    ],
    '/debug/user/reset-identity' => [
        'type' => 2,
    ],
    '/debug/user/*' => [
        'type' => 2,
    ],
    '/debug/*' => [
        'type' => 2,
    ],
    '/gii/default/index' => [
        'type' => 2,
    ],
    '/gii/default/view' => [
        'type' => 2,
    ],
    '/gii/default/preview' => [
        'type' => 2,
    ],
    '/gii/default/diff' => [
        'type' => 2,
    ],
    '/gii/default/action' => [
        'type' => 2,
    ],
    '/gii/default/*' => [
        'type' => 2,
    ],
    '/gii/*' => [
        'type' => 2,
    ],
    '/site/error' => [
        'type' => 2,
    ],
    '/site/captcha' => [
        'type' => 2,
    ],
    '/site/admin' => [
        'type' => 2,
    ],
    '/site/index' => [
        'type' => 2,
    ],
    '/site/login' => [
        'type' => 2,
    ],
    '/site/logout' => [
        'type' => 2,
    ],
    '/site/contact' => [
        'type' => 2,
    ],
    '/site/about' => [
        'type' => 2,
    ],
    '/site/orgs' => [
        'type' => 2,
    ],
    '/site/kek' => [
        'type' => 2,
    ],
    '/site/*' => [
        'type' => 2,
    ],
    '/test/upload' => [
        'type' => 2,
    ],
    '/test/kek' => [
        'type' => 2,
    ],
    '/test/*' => [
        'type' => 2,
    ],
    '/api/objects/by-org' => [
        'type' => 2,
    ],
    '/api/objects/by-org-count' => [
        'type' => 2,
    ],
    '/api/organizations/get-org' => [
        'type' => 2,
    ],
    '/api/organizations/founders' => [
        'type' => 2,
    ],
    '/api/organizations/regions' => [
        'type' => 2,
    ],
    '/api/organizations/org-filter' => [
        'type' => 2,
    ],
    '/api/organizations/all' => [
        'type' => 2,
    ],
    '/api/organizations/obj-count' => [
        'type' => 2,
    ],
    '/api/organizations/users-info' => [
        'type' => 2,
    ],
    '/api/organizations/get-doc-types' => [
        'type' => 2,
    ],
    '/api/regions/all' => [
        'type' => 2,
    ],
    '/api/regions/by-id' => [
        'type' => 2,
    ],
    '/api/regions/countries' => [
        'type' => 2,
    ],
    '/api/user/get-current' => [
        'type' => 2,
    ],
    '/app/admin/data' => [
        'type' => 2,
    ],
    '/app/documents/index' => [
        'type' => 2,
    ],
    '/app/objects/object' => [
        'type' => 2,
    ],
    '/app/objects/area' => [
        'type' => 2,
    ],
    '/app/objects/tariff' => [
        'type' => 2,
    ],
    '/app/objects/money' => [
        'type' => 2,
    ],
    '/app/objects/create' => [
        'type' => 2,
    ],
    '/app/objects/update' => [
        'type' => 2,
    ],
    '/app/objects/set-area' => [
        'type' => 2,
    ],
    '/app/objects/set-money' => [
        'type' => 2,
    ],
    '/app/objects/set-tariff' => [
        'type' => 2,
    ],
    '/app/organizations/users-info' => [
        'type' => 2,
    ],
    '/app/organizations/delete-users-info' => [
        'type' => 2,
    ],
    '/app/organizations/set-files' => [
        'type' => 2,
    ],
    '/app/organizations/del-file' => [
        'type' => 2,
    ],
    '/app/organizations/set-org-info' => [
        'type' => 2,
    ],
    '/app/organizations/set-org-area' => [
        'type' => 2,
    ],
    '/app/organizations/set-org-living' => [
        'type' => 2,
    ],
    '/app/passport/index' => [
        'type' => 2,
    ],
    '/app/passport/org-info' => [
        'type' => 2,
    ],
    '/app/passport/area-info' => [
        'type' => 2,
    ],
    '/app/passport/living-info' => [
        'type' => 2,
    ],
    '/app/passport/living-info-inv' => [
        'type' => 2,
    ],
];
