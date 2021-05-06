<?php

const api = [
    'api/user/current' => 'api/user/get-current',
    'api/user/info/<id_org:\d+>' => 'api/user/info',
    'api/regions' => 'api/regions/all',

    'api/get-doc-types/<id_org:\d+>' => 'api/organizations/get-doc-types',
    'api/get-obj-doc-types/<id_obj:\d+>' => 'api/objects/get-doc-types',

    'api/organization/by-id/<id:\d+>' => 'api/organizations/get-org',
    'api/organization/users/<id:\d+>' => 'api/organizations/users-info',
    'api/organization/count-obj/<id:\d+>' => 'api/organizations/obj-count',

    'api/objects/org/<id_org:\d+>' => 'api/objects/by-org',
    'api/objects/org/<id_org:\d+>/<id_object:\d+>' => 'api/objects/by-org-one',
    'api/cnt-objects/org/<id_org:\d+>' => 'api/objects/by-org-count',
    'api/get-countries/' => 'api/regions/countries',
];

const app = [
    'admin/statistic' => 'app/admin',

    'admin/data/<id_org:\d+>' => 'app/passport',

    '/admin/add-contact/<id_org:\d+>' => 'app/passport/add-contact',

    '/admin/org-info/<id_org:\d+>' => 'app/passport/org-info',
    '/admin/org-covid/<id_org:\d+>' => 'app/passport/org-covid',
    '/admin/area-info/<id_org:\d+>' => 'app/passport/area-info',
    '/admin/living-info/<id_org:\d+>' => 'app/passport/living-info',
    '/admin/living-info-inv/<id_org:\d+>' => 'app/passport/living-info-inv',

    '/admin/objects-info/<id_org:\d+>/<id_object:\d+>' => 'app/objects/object',
    '/admin/objects-area/<id_org:\d+>/<id_object:\d+>' => 'app/objects/area',
    '/admin/objects-money/<id_org:\d+>/<id_object:\d+>' => 'app/objects/money',
    '/admin/objects-tariff/<id_org:\d+>/<id_object:\d+>' => 'app/objects/tariff',
    '/admin/objects-end/<id_org:\d+>/<id_object:\d+>' => 'app/objects/end',

    '/admin/documents/<id_org:\d+>' => 'app/documents',

    'main' => 'app/passport',

    'add-contact' => 'app/passport/add-contact',

    'org-info' => 'app/passport/org-info',
    'org-covid' => 'app/passport/org-covid',
    'area-info' => 'app/passport/area-info',
    'living-info' => 'app/passport/living-info',
    'living-info-inv' => 'app/passport/living-info-inv',

    'objects-info/<id_object:\d+>' => 'app/objects/object',
    'objects-area/<id_object:\d+>' => 'app/objects/area',
    'objects-money/<id_object:\d+>' => 'app/objects/money',
    'objects-tariff/<id_object:\d+>' => 'app/objects/tariff',
    'objects-end/<id_object:\d+>' => 'app/objects/end',

    'documents' => 'app/documents',

    'manual' => 'app/manual',

    'organization/users-info/<id:\d+>' => 'app/organizations/users-info',
    'organization/users-info/<id:\d+>/delete' => 'app/organizations/delete-users-info',
    'organization/set-org-info/<id:\d+>' => 'app/organizations/set-org-info',
    'organization/set-org-covid/<id:\d+>' => 'app/organizations/set-org-covid',
    'organization/set-org-area/<id:\d+>' => 'app/organizations/set-org-area',
    'organization/set-org-living/<id:\d+>' => 'app/organizations/set-org-living',
    'organization/set-org-files/<id_org:\d+>' => 'app/organizations/set-files',
    'organization/del-file/<id_org:\d+>' => 'app/organizations/del-file',
    'organization/set-val/<id:\d+>' => 'app/organizations/set-org-value',

    'object/create/<id_org:\d+>' => 'app/objects/create',
    'object/delete/<id:\d+>' => 'app/objects/delete',
    'object/update/<id:\d+>' => 'app/objects/update',
    'object/set-area/<id:\d+>' => 'app/objects/set-area',
    'object/set-money/<id:\d+>' => 'app/objects/set-money',
    'object/set-tariff/<id:\d+>' => 'app/objects/set-tariff',
    'object/update-count/<id:\d+>' => 'app/objects/update-count',
    'object/set-obj-files/<id_obj:\d+>' => 'app/objects/set-files',
    'object/del-file/<id_obj:\d+>' => 'app/objects/del-file',

];

return array_merge(api, app);
