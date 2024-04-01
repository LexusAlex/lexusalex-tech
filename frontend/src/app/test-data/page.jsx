'use client';
import {Data} from "@/components/Backend/Data";
import {Suspense} from "react";
import Loading from "@/app/loading";

export default async function TestData(){
    const data = await Data();
    return (
        <>
            <Suspense fallback={<Loading />}>
                <p>{data[0].title}</p>
            </Suspense>
        </>
    );
}