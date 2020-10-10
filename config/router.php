<?php

const api = [
    'api/user/current'=>'api/user/get-current',
    'api/user/info/<id_org:\d+>'=>'api/user/info',
    'api/regions'=>'api/regions/all',

    'api/get-doc-types/<id_org:\d+>'=>'api/organizations/get-doc-types',

    'api/organization/by-id/<id:\d+>'=>'api/organizations/get-org',
    'api/organization/users/<id:\d+>'=>'api/organizations/users-info',
    'api/organization/count-obj/<id:\d+>'=>'api/organizations/obj-count',

    'api/objects/org/<id_org:\d+>'=>'api/objects/by-org',
    'api/cnt-objects/org/<id_org:\d+>'=>'api/objects/by-org-count',
];

const app = [
    'main'=>'app/passport',
    'org-info'=>'app/passport/org-info',
    'area-info'=>'app/passport/area-info',
    'living-info'=>'app/passport/living-info',
    'living-info-inv'=>'app/passport/living-info-inv',

    'objects-info'=>'app/objects/object',
    'objects-area'=>'app/objects/area',
    'objects-tariff'=>'app/objects/tariff',
    'objects-money'=>'app/objects/money',

    'documents'=>'app/documents',
    'manual'=>'app/manual',

    'organization/users-info/<id:\d+>'=>'app/organizations/users-info',
    'organization/users-info/<id:\d+>/delete'=>'app/organizations/delete-users-info',
    'organization/set-org-info/<id:\d+>'=>'app/organizations/set-org-info',

    'organization/set-org-area/<id:\d+>'=>'app/organizations/set-org-area',
    'organization/set-org-living/<id:\d+>'=>'app/organizations/set-org-living',
    'organization/set-org-files/<id_org:\d+>'=>'app/organizations/set-files',
    'organization/del-file/<id_org:\d+>'=>'app/organizations/del-file',

    'object/create/<id_org:\d+>'=>'app/objects/create',
    'object/update/<id:\d+>'=>'app/objects/update',
    'object/set-area/<id:\d+>'=>'app/objects/set-area',
    'object/set-money/<id:\d+>'=>'app/objects/set-money',
    'object/set-tariff/<id:\d+>'=>'app/objects/set-tariff'

];

return array_merge(api,app);