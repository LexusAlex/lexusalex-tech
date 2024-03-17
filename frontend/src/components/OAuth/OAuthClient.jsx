import { OAuth2Client} from "oslo/oauth2";

const authorizeEndpoint = "http:/127.0.0.1:8080/authorize";
const tokenEndpoint = "http:/127.0.0.1:8080/token";
const clientId = 'frontend';
const redirectUrl = "http://127.0.0.1/oauth";

const oauth2Client = new OAuth2Client(clientId, authorizeEndpoint, tokenEndpoint, {
    redirectURI: redirectUrl
});
export default oauth2Client;