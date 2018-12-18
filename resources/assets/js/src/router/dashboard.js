// Containers
import Full from 'containers/Full';

// Views
import Dashboard from 'views/Dashboard';

// Views - Components
import Cards from 'views/base/Cards';
import Forms from 'views/base/Forms';
import Tables from 'views/base/Tables';
import UsersList from 'views/users/List';
import ProjectList from 'views/projects/List';
import EvaluationForm from 'views/performance-evaluation/Form';
import QuestionList from 'views/questions/List';
import Session from 'views/sessions/List'
import ReportExport from 'views/reports/Export'
import ReportEntry from 'views/reports/Entry'
import SessionDetail from 'views/sessions/Detail';
import AppraisalDetails from 'views/sessions/Detail';
import ProjectEmployee from 'views/project-employee/List';
import EmployeeEvaluation from 'views/AWEvaluations/List';

export default [
  {
    path: '/',
    redirect: '/dashboard',
    name: 'Home',
    component: Full,
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: Dashboard
      },
      {
        path: 'session',
        redirect: '/session/list',
        name: 'Session',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'list',
            name: 'Session List',
            component: Session
          },
          {
            path: 'detail/:id/:code',
            name: 'Detail',
            component: SessionDetail
          }
        ]
      },
      {
        path: 'Appraisal',
        redirect: '/appraisal/list',
        name: 'Appraisal',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'list',
            name: 'Appraisal List',
            component: AppraisalDetails
          }
        ]
      },
      {
        path: 'project-employee',
        redirect: '/project-employee/list',
        name: 'Project Employee',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'list',
            name: 'Project Employee List',
            component: ProjectEmployee
          }
        ]
      },
      {
        path: 'employee-evaluations',
        redirect: '/employee-evaluations/list',
        name: 'Employee Evaluation',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'list',
            name: 'Employee Evaluation List',
            component: EmployeeEvaluation
          }
        ]
      },
      {
        path: 'employees',
        redirect: '/employees/list',
        name: 'Employees',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'list',
            name: 'Employee List',
            component: UsersList
          }
        ]
      },
      {
        path: 'projects',
        redirect: '/projects/list',
        name: 'Projects',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'list',
            name: 'Project List',
            component: ProjectList
          }
        ]
      },
      {
        path: 'questions',
        redirect: '/questions/list',
        name: 'Questions',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'list',
            name: 'Question List',
            component: QuestionList
          }
        ]
      },
      {
        path: 'performance-evaluation',
        redirect: '/performance-evaluation/form',
        name: 'Performance Evaluation',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'form',
            name: 'Evaluation Form',
            component: EvaluationForm
          }
        ]
      },
      {
        path: 'reports',
        redirect: '/reports/entry',
        name: 'Report Entry',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'entry',
            name: 'Report Entry Form',
            component: ReportEntry
          }
        ]
      },
      {
        path: 'reports',
        redirect: '/reports/export',
        name: 'Report',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'export',
            name: 'Export',
            component: ReportExport
          }
        ]
      },
      {
        path: 'base',
        redirect: '/base/cards',
        name: 'Base',
        component: {
          render(c) {
            return c('router-view')
          }
        },
        children: [
          {
            path: 'cards',
            name: 'Cards',
            component: Cards
          },
          {
            path: 'forms',
            name: 'Forms',
            component: Forms
          },
          {
            path: 'tables',
            name: 'Tables',
            component: Tables
          }
        ]
      },
    ]
  }
]