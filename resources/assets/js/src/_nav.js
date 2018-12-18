export default {
  items: [
    {
      name: 'Dashboard',
      url: '/dashboard',
      icon: 'icon-speedometer',
    },
    {
      name: 'Employees',
      url: '/employees/list',
      icon: 'icon-user',
    },
    {
      name: 'Projects',
      url: '/projects/list',
      icon: 'fa fa-book',
    },
    {
      name: 'Evaluations',
      url: '/employee-evaluations/list',
      icon: 'fa fa-book',
    },
    {
      name: 'p. Evaluation',
      url: '/performance-evaluation',
      icon: 'fa fa-book',
    },
    {
      name: 'Base',
      url: '/base',
      icon: 'icon-puzzle',
      children: [
        {
          name: 'Cards',
          url: '/base/cards',
          icon: 'icon-puzzle'
        },
        {
          name: 'Forms',
          url: '/base/forms',
          icon: 'icon-puzzle'
        },
        {
          name: 'Tables',
          url: '/base/tables',
          icon: 'icon-puzzle'
        }
      ]
    },
  ]
}
