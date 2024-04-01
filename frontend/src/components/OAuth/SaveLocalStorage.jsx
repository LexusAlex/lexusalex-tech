'use client';
import {redirect} from "next/navigation";
export default function SaveLocalStorage({codeVerifier,state,url})
{
    window.localStorage.setItem('auth.location', '/'); // TODO переделать редирект на нужную страницу
    window.localStorage.setItem('auth.code_verifier', codeVerifier);
    window.localStorage.setItem('auth.state', state);

    return redirect(url);
}