"use client"
import {useEffect} from "react";

export default function AuthProvider() {
    useEffect(() => {
         fetch(process.env.TOKEN_PATH,{})
             .then(() => {
                 // setauth
             })
    }, []);
    return (
        <></>
    )
}