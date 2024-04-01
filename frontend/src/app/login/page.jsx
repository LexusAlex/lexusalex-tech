import {generateCodeVerifier, generateState} from "oslo/oauth2";
import oauth2Client from "@/components/OAuth/OAuthClient";
import SaveLocalStorage from "@/components/OAuth/SaveLocalStorage";

export default async function Login() {
    const state = generateState();
    const codeVerifier = generateCodeVerifier(); // for PKCE flow
    const url = await oauth2Client.createAuthorizationURL({
        state,
        scopes: ["common"],
        codeVerifier
    });

    return (<SaveLocalStorage codeVerifier={codeVerifier} state={state} url={url} />);
}