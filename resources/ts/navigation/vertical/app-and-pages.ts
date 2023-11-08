export default [
  {
    heading:'Case Management',
    subject: 'Case Management',
  },
  {
    title: 'FPN', 
    to: 'enviro',
    subject: 'Case Management',
    icon: { icon: 'mdi-view-module' },
  },
  {
    title: 'Service Request', 
    to: 'servicerequest',
    icon: { icon: 'mdi-face-agent' },
    subject: 'Case Management',
  },
  {
    title: 'Representation', 
    to: 'list-rep',
    subject: 'Case Management',
    icon: { icon: 'mdi-tree-outline' },
  },
  {
    title: 'Walk Off List', 
    to: '',
    subject: 'Case Management',
    icon: { icon: 'mdi-file-tree-outline' },
  },
  {
    heading:'Admin & Set Up',
    subject: 'Admin',
  },
  {
    title: 'Admin',
    icon: { icon: 'mdi-account-outline' },
    children: [
      { title: 'Users',to: 'users',},
      { title: 'Roles', to: 'Role' },
      { title: 'Permissions', to: "Role Rights" },
      { title: 'Sites',   to: 'sites'},
      { title: 'Organization', to: "Organization" },
      { title: 'BWC', to: "Bwc" },
      { title: 'Region', to: "Region" },
      {
        title: 'FPN Master',
        children: [
          {
            title: 'Offence Group',
            to: 'offence-group',
          },
          {
            title: 'Offences',
            to: 'offence',
          },
          {
            title: 'Offence Location Prefix',
            to: 'offence-location-prefix',
          },
          {
            title: 'Offence How',
            to: 'offence-how',
          },
          {
            title: 'Address Verified By',
            to: 'address-verified-by',
          },
          {
            title: 'Ethnicity',
            to: 'ethnicity',
          },
          {
            title: 'Offence Location Suffix',
            to: 'offence-location-suffix',
          },
          {
            title: 'Weather',
            to: 'weather',
          },
          {
            title: 'Offender Hair Colour',
            to: 'offender-hair-colour',
          },
          {
            title: 'Offender Build',
            to: 'offender-build',
          },
          {
            title: 'ID Shown',
            to: 'id-shown',
          },
          {
            title: 'Visibility',
            to: 'visibility',
          },
          {
            title: 'Write Off Codes',
            to: 'write-off-code',
          },
          {
            title: 'Cancel Codes',
            to: 'cancel-code',
          },
          {
            title: 'Payment Methods',
            to: 'payment-method',
          },
          {
            title: 'Legislations',
            to: 'legislation',
          },
          {
            title: 'Type Of Land',
            to: 'type-of-land',
          },
          {
            title: 'Type Of Dog',
            to: 'type-of-dog',
          },
          {
            title: 'Dog Size',
            to: 'dog-size',
          },
          {
            title: 'Dog Under Control',
            to: 'dog-under-control',
          },{
            title: 'Manual Rep. Reasons',
            to: 'manual-representation-reason',
          },
          {
            title: 'Rep. Accept Reasons',
            to: 'representation-accept-reason',
          },
          {
            title: 'Rep. Decline Reasons',
            to: 'representation-decline-reason',
          },
          {
            title: 'Produced Waste Transfer',
            to: 'produced-waste-transfer',
          },
          {
            title: 'Waste Type',
            to: 'waste-type',
          },
          {
            title: 'Applicant Type',
            to: 'applicant-type',
          },
          {
            title: 'Company Registered Type',
            to: 'company-registered-type',
          }    
        ],
        action: 'manage',
        subject: 'Enviro Master',
      },
      {
        title: 'Service Request Master',
        children: [
          {
            title: 'Management',
            to: '',
            subject: 'Service Requests',
          },
          {
            title: 'SR Type',
            to: 'service-request-type',
            subject: 'Service Requests',
          },
          {
            title: 'SR Reported Via',
            to: 'service-request-reported-via',
            subject: 'Service Requests',
          },
          {
            title: 'SR Closed Codes',
            to: 'service-request-closed-codes',
            subject: 'Service Requests',
          },
          {
            title: 'SR Task Group',
            to: 'service-request-task-group',
            subject: 'Service Requests',
          },
          {
            title: 'SR Task Type',
            to: 'service-request-task-type',
            subject: 'Service Requests',
          },
          {
            title: 'Position of Employment',
            to: 'position-of-employment',
            subject: 'Service Requests',
          },
        ],
        action: 'manage',
        subject: 'Service Requests',
      },
    ],
    action: 'manage',
    subject: 'Admin',
  },
  {
    heading:'Device Control',
    subject: 'Setup',
  },
  {
    title: 'Device Control',
    icon: { icon: 'mdi-file-document-outline' },
    children: [
      {
        title: 'GEO(Live)', 
        to: '',
        subject: 'Reports',
      },
      {
        title: 'GEO(Offline)', 
        to: '',
        subject: 'Reports',
      }      
    ],
    action: 'manage',
    subject: 'Reports',
  }, 
  {
    heading:'Letters',
    subject: 'Letters',
  },
  {
    title: 'Letters',
    icon: { icon: 'mdi-email-outline' },
    children: [
      {
        title: 'Manage Letters',
        action: 'manage',
        subject: 'Letters',
      },
      {
        title: 'Letter Fields', 
        action: 'manage',
        subject: 'Letters',
      },
      {
        title: 'Letter Design', 
        action: 'manage',
        subject: 'Letters',
      },
      {
        title: 'Print Schedule', 
        action: 'manage',
        subject: 'Letters',
      }      
    ],
    action: 'manage',
    subject: 'Letters',
  },
  {
    heading:'Reports',
    subject: 'Reports',
  },
  {
    title: 'Reports',
    icon: { icon: 'mdi-file-document-outline' },
    children: [
      {
        title: 'General', 
        to: '',
        subject: 'Reports',
      },
      {
        title: 'Enviro', 
        to: '',
        subject: 'Reports',
      },
      {
        title: 'Service Request', 
        to: '',
        subject: 'Reports',
      }      
    ],
    action: 'manage',
    subject: 'Reports',
  },
  {
    heading:'Support',
    subject: 'Reports',
  },
  {
    title: 'Contact Us',
    icon: { icon: 'mdi-file-document-outline' },
    children: [
      {
        title: 'Contact Us', 
        action: 'manage',
        subject: 'Reports',
      }     
    ],
    action: 'manage',
    subject: 'Reports',
  },
  
]
