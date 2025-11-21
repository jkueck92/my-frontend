import { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function urlIsActive(
    urlToCheck: NonNullable<InertiaLinkProps['href']>,
    currentUrl: string,
) {
    const checkUrl = toUrl(urlToCheck);

    // Exakte Übereinstimmung
    if (checkUrl === currentUrl) return true;
    
    // Wenn currentUrl mit checkUrl/ beginnt (Unterpfade)
    if (currentUrl.startsWith(checkUrl + '/')) return true;
    
    // Spezialfall: Root-Pfade
    if (checkUrl !== '/' && currentUrl.startsWith(checkUrl)) return true;
    
    return false;
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}
