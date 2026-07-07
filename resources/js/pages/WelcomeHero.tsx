import { ArrowUpRight } from 'lucide-react';
import { motion } from 'motion/react';
 import { Button } from '@/components/ui/button';
import { register } from '@/routes';
import { Link } from '@inertiajs/react';



export type AvatarList = {
    image: string;
};



export default function WelcomeHero() {
    return (
        <section>
            <div className="relative h-full w-full">
                <div className="relative w-full pt-0 pb-6 before:absolute before:top-24 before:-z-10 before:h-full before:w-full before:rounded-full before:bg-linear-to-r before:from-sky-100 before:via-white before:to-amber-100 before:blur-3xl md:pt-20 md:pb-10 dark:before:-z-10 dark:before:rounded-full dark:before:from-slate-800 dark:before:via-black dark:before:to-stone-700 dark:before:blur-3xl">
                    <div className="relative z-10 container mx-auto">
                        <div className="mx-auto flex max-w-5xl flex-col gap-8">
                            <div className="relative flex flex-col items-center gap-4 text-center sm:gap-6">
                                <motion.h1
                                    initial={{ opacity: 0, y: 32 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    transition={{
                                        duration: 2,
                                        ease: 'easeInOut',
                                    }}
                                    className="text-5xl text-cyan-400 leading-14 font-medium md:text-7xl md:leading-20 lg:text-8xl lg:leading-24"
                                >
                                    UniMan: Платформа за управление на дипломни работи{' '}

                                </motion.h1>
                                <motion.p
                                    initial={{ opacity: 0, y: 32 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    transition={{
                                        duration: 3,
                                        delay: 0.1,
                                        ease: 'easeInOut',
                                    }}
                                    className="max-w-2xl text-base font-normal text-muted-foreground"
                                >
                                    Дипломен проект с потребителски интерфейс, реализиран чрез shadcn/ui, Laravel бекенд и InertiaJS "мостов" компонент.
                                </motion.p>
                            </div>
                            <motion.div
                                initial={{ opacity: 0, y: 32 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{
                                    duration: 1,
                                    delay: 0.2,
                                    ease: 'easeInOut',
                                }}
                                className="flex flex-col items-center justify-center gap-8 md:flex-row"
                            >
                                <Link
                                    href={register()}
                                 >
                                <Button className="group relative h-12 w-fit cursor-pointer overflow-hidden rounded-full p-1 ps-6 pe-14 text-sm font-medium transition-all duration-500 hover:ps-14 hover:pe-6">
                                    <span className="relative z-10 transition-all duration-500">
                                        Към Табло
                                    </span>
                                    <span className="absolute right-1 flex h-10 w-10 items-center justify-center rounded-full bg-background text-foreground transition-all duration-500 group-hover:right-[calc(100%-44px)] group-hover:rotate-45">
                                        <ArrowUpRight size={16} />
                                    </span>
                                </Button>
                                </Link>
                            </motion.div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

