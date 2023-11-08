import Organization from "@/pages/admin/organization/index.vue"
import Role from '@/pages/admin/role/index.vue'
import RoleRight from "@/pages/admin/roleright/index.vue"
import AddUser from "@/pages/admin/user/add.vue"
import EditUser from "@/pages/admin/user/edit.vue"
import User from "@/pages/admin/user/index.vue"
import EnviroDetails from '@/pages/case-management/enviro/details.vue'
import EnviroPage from '@/pages/case-management/enviro/index.vue'
import EnviroAddressVerifiedByPage from '@/pages/case-management/enviro/master/address-verified-by/index.vue'
import EnviroApplicantType from '@/pages/case-management/enviro/master/applicant-type/index.vue'
import EnviroBwcPage from '@/pages/case-management/enviro/master/bwc/index.vue'
import EnviroCancelCodePage from '@/pages/case-management/enviro/master/cancel-code/index.vue'
import EnviroCompanyRegisteredType from '@/pages/case-management/enviro/master/company-registered-type/index.vue'
import EnviroDogSizePage from '@/pages/case-management/enviro/master/dog-size/index.vue'
import EnviroDogUnderControlPage from '@/pages/case-management/enviro/master/dog-under-control/index.vue'
import EnviroEthnicityPage from '@/pages/case-management/enviro/master/ethnicity/index.vue'
import EnviroIdShownPage from '@/pages/case-management/enviro/master/id-shown/index.vue'
import EnviroLegislationPage from '@/pages/case-management/enviro/master/legislation/index.vue'
import EnviroManualRepresentationReasons from '@/pages/case-management/enviro/master/manual-representation-reason/index.vue'
import EnviroOffenceGroupPage from '@/pages/case-management/enviro/master/offence-group/index.vue'
import EnviroOffenceHowPage from '@/pages/case-management/enviro/master/offence-how/index.vue'
import EnviroOffenceLocationPrefixPage from '@/pages/case-management/enviro/master/offence-location-prefix/index.vue'
import EnviroOffenceLocationSuffixPage from '@/pages/case-management/enviro/master/offence-location-suffix/index.vue'
import EnviroAddOffencePage from '@/pages/case-management/enviro/master/offence/add.vue'
import EnviroEditOffencePage from '@/pages/case-management/enviro/master/offence/edit.vue'
import EnviroOffencePage from '@/pages/case-management/enviro/master/offence/index.vue'
import EnviroOffenderBuildPage from '@/pages/case-management/enviro/master/offender-build/index.vue'
import EnviroOffenderHairColourPage from '@/pages/case-management/enviro/master/offender-hair-colour/index.vue'
import EnviroPaymentMethodPage from '@/pages/case-management/enviro/master/payment-method/index.vue'
import PositionOfEmployment from '@/pages/case-management/enviro/master/position-of-employment/index.vue'
import EnviroProducedWasteTransfer from '@/pages/case-management/enviro/master/produced-waste-transfer/index.vue'
import EnviroRegionPage from '@/pages/case-management/enviro/master/region/index.vue'
import EnviroRepresentationAcceptReasons from '@/pages/case-management/enviro/master/representation-accept-reason/index.vue'
import EnviroRepresentationDeclineReasons from '@/pages/case-management/enviro/master/representation-decline-reason/index.vue'
import RepresentationPage from '@/pages/case-management/enviro/master/representation/index.vue'
import ServiceRequestClosedCodes from '@/pages/case-management/enviro/master/service-request-closed-codes/index.vue'
import ServiceRequestReportedVia from '@/pages/case-management/enviro/master/service-request-reported-via/index.vue'
import ServiceRequestTaskGroup from '@/pages/case-management/enviro/master/service-request-task-group/index.vue'
import ServiceRequestTaskType from '@/pages/case-management/enviro/master/service-request-task-type/index.vue'
import ServiceRequestType from '@/pages/case-management/enviro/master/service-request-type/index.vue'
import EnviroTypeOfDogPage from '@/pages/case-management/enviro/master/type-of-dog/index.vue'
import EnviroTypeOfLandPage from '@/pages/case-management/enviro/master/type-of-land/index.vue'
import EnviroVisibilityPage from '@/pages/case-management/enviro/master/visibility/index.vue'
import EnviroWasteType from '@/pages/case-management/enviro/master/waste-type/index.vue'
import EnviroWeatherPage from '@/pages/case-management/enviro/master/weather/index.vue'
import EnviroWriteOffCodePage from '@/pages/case-management/enviro/master/write-off-code/index.vue'
import AddLetter from "@/pages/letters/letters/AddLetter.vue"
import AddSite from "@/pages/setup/sites/CreateSite.vue"
import EditSite from "@/pages/setup/sites/EditSite.vue"
import Site from "@/pages/setup/sites/ManageSites.vue"
import AddService from '@/pages/sr-management/servicerequest/add.vue'
import SRDetails from '@/pages/sr-management/servicerequest/detail.vue'
import ServiceRequestPage from '@/pages/sr-management/servicerequest/index.vue'
// import ManageLetter from "@/pages/letters/letters/ManageLetters.vue"

import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import routes from '~pages'

import ResetPassword from '../pages/pages/authentication/reset-password-v1.vue'
import Authenticate from '../pages/pages/authentication/two-steps-v2.vue'

// Midddlware

const admin = [
  {
      path: '/admin/roles',
      name: 'Role',
      component: Role,
      meta: {
        auth: true
      }
  },
  {
    path: '/users',
    name: 'users',
    component: User,
    meta: {
      //layout: 'blank',
      auth: true,
      navActiveLink: 'apps-email',
      layoutWrapperClasses: '',
    }
  },
  {
    path: '/userscreate',
    name: 'add-user',
    component: AddUser,
    meta: { 
      auth: true,
      navActiveLink: 'apps-email',
      layoutWrapperClasses: '',
    }
  },
  {
    path: '/userscreate/:id',
    name: 'edit-user',
    component: EditUser,
    meta: { 
      auth: true,
      navActiveLink: 'apps-email',
      layoutWrapperClasses: '',
    },

  },
  {
    path: '/admin/role-rights',
    name: 'Role Rights',
    component: RoleRight,
    meta: {
      auth: true,
    }
  },
  {
    path: '/admin/organization',
    name: 'Organization',
    component: Organization,
    meta: {
      auth: true,
    }
  },
  {
    path: '/admin/bwc',
    name: 'Bwc',
    component: EnviroBwcPage,
  },
  {
    path: '/admin/region',
    name: 'Region',
    component: EnviroRegionPage,
  }

]
const nesRoutes = [

  // Setup - Sites
  {
    path: '/setup/sites',
    name: 'sites',
    component: Site,
    meta: { 
        auth: true,
        navActiveLink: 'apps-email',
        layoutWrapperClasses: '', 
    },
  },
  {
    path: '/setup/sites/add',
    name: 'add-site',
    component: AddSite,
    meta: { 
        auth: true,
        navActiveLink: 'apps-email',
        layoutWrapperClasses: '', 
    },
  },
  {
    path: '/setup/sites/:id/edit',
    name: 'edit-site',
    component: EditSite,
    meta: { 
        auth: true,
        navActiveLink: 'apps-email',
        layoutWrapperClasses: '', 
    },
  },

  // Letters
  // {
  //   path: '/letters/manage',
  //   name: 'letters',
  //   component: ManageLetter,
  //   meta: { 
  //       auth: true,
  //   },
  // },
  {
    path: '/letters/create',
    name: 'AddLetter',
    component: AddLetter,
    meta: {
      auth: true
    }
  },

  {
    path: '/FPNList/Search',
    name: 'enviro',
    component: EnviroPage,
    meta: { 
        auth: true,
        navActiveLink: 'apps-email',
        layoutWrapperClasses: '', 
    },
  },
  {
    path: '/service-request',
    name: 'servicerequest',
    component: ServiceRequestPage,
    meta: { 
        auth: true,
        navActiveLink: 'apps-email',
        layoutWrapperClasses: '', 
    },
  },
  {
    path: '/ServiceRequestList/:id/details',
    name: 'service-request-details',
    component: SRDetails,
    meta: { 
        auth: true,
    },
  },
  {
    path: '/FPNList/:id/details',
    name: 'enviro-details',
    component: EnviroDetails,
    meta: { 
        auth: true,
    },
  },
  {
    path: '/RepList/Search',
    name: 'list-rep',
    component: RepresentationPage,
    meta: { 
        auth: true,
        navActiveLink: 'apps-email',
        layoutWrapperClasses: '', 
    },
  },
  {
    path: '/LOVF/editoffence/:id',
    name: 'edit-offence',
    component: EnviroEditOffencePage,
    meta: {
      //layout: 'blank',
      navActiveLink: 'apps-email',
      layoutWrapperClasses: '',
    },

},
{
  path: '/LOVF/addoffence',
  component: EnviroAddOffencePage,
  name: 'add-offence',
  meta: {
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '',
  },
},
{
  path: '/LOVF/offence',
  component: EnviroOffencePage,
  name: 'offence',
  meta: {
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '',
  },
},
{
  path: '/LOVF/offenceGroup',
  component: EnviroOffenceGroupPage,
  name: 'offence-group',
  meta: {
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '',
  },
},
{
  path: '/LOVF/Index/ofh',
  name: 'offence-how',
  component: EnviroOffenceHowPage,
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},

},
{
  path: '/LOVF/Index/ppf',
  name: 'offence-location-prefix',
  component: EnviroOffenceLocationPrefixPage,
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},

},
{
  path: '/LOVF/Index/avb',
  name: 'address-verified-by',
  component: EnviroAddressVerifiedByPage,
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},

},
{
  path: '/LOVF/Index/ehc',
  name: 'ethnicity',
  component: EnviroEthnicityPage,
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},

},
{
  path: '/LOVF/Index/ols',
  component: EnviroOffenceLocationSuffixPage,
  name: 'offence-location-suffix',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},

},
{
  path: '/LOVF/Index/wt',
  component: EnviroWeatherPage,
  name: 'weather',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/Index/ohc',
  component: EnviroOffenderHairColourPage,
  name: 'offender-hair-colour',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/Index/ob',
  component: EnviroOffenderBuildPage,
  name: 'offender-build',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/Index/ish',
  component: EnviroIdShownPage,
  name: 'id-shown',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/Visibility',
  component: EnviroVisibilityPage,
  name: 'visibility',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/WriteOffCodes',
  component: EnviroWriteOffCodePage,
  name: 'write-off-code',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/CancelCodes',
  component: EnviroCancelCodePage,
  name: 'cancel-code',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/PaymentMethods',
  component: EnviroPaymentMethodPage,
  name: 'payment-method',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/FLegislations',
  component: EnviroLegislationPage,
  name: 'legislation',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/TypeOfLand',
  component: EnviroTypeOfLandPage,
  name: 'type-of-land',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/TypeOfDog',
  component: EnviroTypeOfDogPage,
  name: 'type-of-dog',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/DogSize',
  component: EnviroDogSizePage,
  name: 'dog-size',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVF/DogUnderControl',
  component: EnviroDogUnderControlPage,
  name: 'dog-under-control',
  meta: { 
    //layout: 'blank',
    auth: true,
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/ManualRepresentationReasons',
  component: EnviroManualRepresentationReasons,
  name: 'manual-representation-reason',
  meta: { 
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/RepresentationAcceptReasons',
  component: EnviroRepresentationAcceptReasons,
  name: 'representation-accept-reason',
  meta: { 
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/RepresentationDeclineReasons',
  component: EnviroRepresentationDeclineReasons,
  name: 'representation-decline-reason',
  meta: { 
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/ProducedWasteTransfer',
  component: EnviroProducedWasteTransfer,
  name: 'produced-waste-transfer',
  meta: { 
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/WasteType',
  component: EnviroWasteType,
  name: 'waste-type',
  meta: { 
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/ApplicantType',
  component: EnviroApplicantType,
  name: 'applicant-type',
  meta: { 
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/CompanyRegisteredType',
  component: EnviroCompanyRegisteredType,
  name: 'company-registered-type',
  meta: { 
    //layout: 'blank',
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/ServiceRequestType',
  component: ServiceRequestType,
  name: 'service-request-type',
  meta: { 
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},  
{
  path: '/LOVS/ServiceRequestReportedVia',
  component: ServiceRequestReportedVia,
  name: 'service-request-reported-via',
  meta: { 
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/ServiceRequestClosedCodes',
  component: ServiceRequestClosedCodes,
  name: 'service-request-closed-codes',
  meta: { 
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/PositionOfEmployment',
  component: PositionOfEmployment,
  name: 'position-of-employment',
  meta: { 
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/ServiceRequestTaskType',
  component: ServiceRequestTaskType,
  name: 'service-request-task-type',
  meta: { 
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
{
  path: '/LOVS/ServiceRequestTaskGroup',
  component: ServiceRequestTaskGroup,
  name: 'service-request-task-group',
  meta: { 
    navActiveLink: 'apps-email',
    layoutWrapperClasses: '', 
},
},
]

const servicerequest = [
  {
    path: '/servicecreate',
    name: 'add-service',
    component: AddService,
    meta: { 
      auth: true,
      navActiveLink: 'apps-email',
      layoutWrapperClasses: '',
    }
  },
]
const router = createRouter({
  history: createWebHistory(),
  routes: [
    // ℹ️ We are redirecting to different pages based on role.
    // NOTE: Role is just for UI purposes. ACL is based on abilities.
    {
      path: '/',
      redirect: to => {
        const userData = JSON.parse(localStorage.getItem('userData') || '{}')
        const userRole = userData && userData.role ? userData.role.id : null
        
        let accessToken = localStorage.getItem('accessToken');

        if (userRole)
        {
          if(accessToken){
            return { name: 'dashboards-crm' }
          }
        }
        
        return { name: 'login', query: to.query }
      },
    },

    // {
    //   path: '/login',
    //   name: 'login',
    //   component: Login,
    //   meta: {
    //     auth: false
    //   },
    // },
    {
      path: '/verify/:hash',
      name: 'authenticate',
      component: Authenticate,
      meta: {
        auth: false
      },
    },
    {
      path: '/:hash',
      name: 'reset-password',
      component: ResetPassword,
      meta: {
        auth: false
      },
      props: route => ({
        email: route.query.email
      }),
      beforeEnter: (to, from, next) => {
        if (!to.query.email) {
          next(false);
        } else {
          next();
        }
      }
    },
    {
      path: '/pages/user-profile',
      redirect: () => ({ name: 'pages-user-profile-tab', params: { tab: 'profile' } }),
    },
    {
      path: '/pages/account-settings',
      redirect: () => ({ name: 'pages-account-settings-tab', params: { tab: 'account' } }),
    },

    ...setupLayouts(admin),
    ...setupLayouts(routes),
    ...setupLayouts(nesRoutes),
    ...setupLayouts(servicerequest),

  ],
})

// Docs: https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards
/* router.beforeEach(to => {
  const isLoggedIn = isUserLoggedIn()

  /*

  ℹ️ Commented code is legacy code

  if (!canNavigate(to)) {
    // Redirect to login if not logged in
    // ℹ️ Only add `to` query param if `to` route is not index route
    if (!isLoggedIn)
      return next({ name: 'login', query: { to: to.name !== 'index' ? to.fullPath : undefined } })

    // If logged in => not authorized
    return next({ name: 'not-authorized' })
  }

  // Redirect if logged in
  if (to.meta.redirectIfLoggedIn && isLoggedIn)
    next('/')

  return next()

  */

//  if (canNavigate(to)) {
//    if (to.meta.redirectIfLoggedIn && isLoggedIn)
//      return '/'
//  }
//  else {
//    if (isLoggedIn)
//      return { name: 'not-authorized' }
//    else
//      return { name: 'login', query: { to: to.name !== 'index' ? to.fullPath : undefined } }
//  }
//})


// Auth Middleware
// Check if the user is loggedin or not
// router.beforeEach((to, from, next) => {
//     const accessToken = localStorage.getItem('accessToken');
//     if (!to.meta.auth) {
//       if(to.path == '/dashboards/crm' && !accessToken)
//       {
//         next('/login')
//       }
//       next();
//     }
//     else if (to.meta.auth === false) {
//       // if auth is not required, skip authentication and continue to the route
//       next();
//     }else{
      
//       if (!accessToken) {
//         // if not authenticated, redirect to the login page
//         next('/login');
//       } else {
//         // if authenticated, continue to the next middleware or route
//         next();
//       }
//     }
// });

export default router
