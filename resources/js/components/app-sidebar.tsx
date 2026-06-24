import { Link, usePage } from '@inertiajs/react';
import {
    Building2,
    CalendarDays,
    ClipboardCheck,
    GraduationCap,
    LayoutGrid,
    School,
    Users,
} from 'lucide-react';

import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import consultationRoutes from '@/routes/consultations';
import facultyRoutes from '@/routes/faculties';
import institutionRoutes from '@/routes/institutions';
import recensionRoutes from '@/routes/recensions';
import specialtyRoutes from '@/routes/specialties';
import termPaperRoutes from '@/routes/term-papers';
import userRoutes from '@/routes/users';
import AppLogo from '@/components/app-logo';

interface NavItem {
    title: string;
    href: string;
    icon: typeof LayoutGrid;
    /** Кой ключ от споделения 'can' проп решава видимостта на този линк. */
    visible: boolean;
}

export function AppSidebar() {
    const { can, auth } = usePage().props;
    const currentUrl = window.location.pathname;


    const navItems: NavItem[] = [
        {
            title: 'Табло',
            href: dashboard().url,
            icon: LayoutGrid,
            visible: true,
        },
        {
            title: 'Курсови работи',
            href: termPaperRoutes.index().url,
            icon: GraduationCap,
            visible: can.termPapers.viewAny,
        },
        {
            title: 'Консултации',
            href: consultationRoutes.index().url,
            icon: CalendarDays,
            visible: can.consultations.viewAny,
        },
        {
            title: 'Рецензии',
            href: recensionRoutes.index().url,
            icon: ClipboardCheck,
            visible: can.recensions.viewAny,
        },
        {
            title: 'Учители',
            href: userRoutes.teachers().url,
            icon: Users,
            visible: can.users.viewTeachers,
        },
    ];

    const adminNavItems: NavItem[] = [
        {
            title: 'Институции',
            href: institutionRoutes.index().url,
            icon: Building2,
            visible: can.institutions.viewAny,
        },
        {
            title: 'Факултети',
            href: facultyRoutes.index().url,
            icon: School,
            visible: can.faculties.viewAny,
        },
        {
            title: 'Специалности',
            href: specialtyRoutes.index().url,
            icon: School,
            visible: can.specialties.viewAny,
        },
        {
            title: 'Студенти',
            href: userRoutes.students().url,
            icon: Users,
            visible: can.users.viewStudents,
        },
    ];

    const visibleNavItems = navItems.filter((item) => item.visible);
    const visibleAdminItems = adminNavItems.filter((item) => item.visible);

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard().url}>
                                  <AppLogo/>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <SidebarGroup>
                    <SidebarGroupLabel>Навигация</SidebarGroupLabel>
                    <SidebarGroupContent>
                        <SidebarMenu>
                            {visibleNavItems.map((item) => (
                                <SidebarMenuItem key={item.href}>
                                    <SidebarMenuButton
                                        asChild
                                        isActive={currentUrl.startsWith(
                                            item.href,
                                        )}
                                        tooltip={item.title}
                                    >
                                        <Link href={item.href}>
                                            <item.icon />
                                            <span>{item.title}</span>
                                        </Link>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                            ))}
                        </SidebarMenu>
                    </SidebarGroupContent>
                </SidebarGroup>

                {/* Административна група - рендерира се само ако има поне
                    един видим елемент в нея, за да не остава празен,
                    подвеждащ заглавен ред за обикновени студенти/преподаватели. */}
                {visibleAdminItems.length > 0 && (
                    <SidebarGroup>
                        <SidebarGroupLabel>Управление</SidebarGroupLabel>
                        <SidebarGroupContent>
                            <SidebarMenu>
                                {visibleAdminItems.map((item) => (
                                    <SidebarMenuItem key={item.href}>
                                        <SidebarMenuButton
                                            asChild
                                            isActive={currentUrl.startsWith(
                                                item.href,
                                            )}
                                            tooltip={item.title}
                                        >
                                            <Link href={item.href}>
                                                <item.icon />
                                                <span>{item.title}</span>
                                            </Link>
                                        </SidebarMenuButton>
                                    </SidebarMenuItem>
                                ))}
                            </SidebarMenu>
                        </SidebarGroupContent>
                    </SidebarGroup>
                )}
            </SidebarContent>

            <SidebarFooter>
                <NavUser  />
            </SidebarFooter>
        </Sidebar>
    );
}

export default AppSidebar;
