import appAndPages from './app-and-pages'
import dashboard from './dashboard'

import type { VerticalNavItems } from '@/@layouts/types'

export default [...dashboard, ...appAndPages] as VerticalNavItems
