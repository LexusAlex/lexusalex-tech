
import { NextResponse } from "next/server";


const protectedRoutes = ["/test"];

export default function middleware(req) {
    if (true && protectedRoutes.includes(req.nextUrl.pathname)) {
        const absoluteURL = new URL("/login", req.nextUrl.origin);
        return NextResponse.redirect(absoluteURL.toString());
    }
}