import { Injectable } from "@angular/core";
import { ScriptStore } from "./script.store";

declare var document: any;

@Injectable()
export class ScriptService {

	private scripts: any = {};

	constructor() {
	    ScriptStore.forEach((script: any) => {
	        this.scripts[script.name] = {
	            loaded: false,
	            src: script.src
	        };
	    });
	}

	load(...scripts: string[]): Promise<any>
	{
    var promises: any[] 				= 			[];
    scripts.forEach((script) => promises.push(this.loadScript(script)));

    return 															Promise.all(promises);
	}

	loadScript(name: string): Promise<any>
	{
    return new Promise((resolve, reject) => {


    	// if script has already been loaded.
	    if(this.scripts[name].loaded)
	    {
				resolve({script: name, loaded: true, status: 'Already Loaded'});
	    }


	    // fetch script that has not been loaded.
      else 
      {
      	// create the <script> DOM object to 
      	// inject into the DOM <HEAD>
				let script = document.createElement('script');
				script.type = 'text/javascript';
				script.src = this.scripts[name].src;


				// check for the `readyState` property 
				// prior to loading remote scripts
				// to account for old IE browsers.
	      if (script.readyState) 
	      {
					script.onreadystatechange = () => {
            if (script.readyState === "loaded" || script.readyState === "complete") {
              script.onreadystatechange 			= 		null;
              this.scripts[name].loaded 			= 		true;
              resolve({script: name, loaded: true, status: 'Loaded'});
            }
          };
	      } 


	      // Non-IE browsers can just append
	      // the promise resolution to the page's
	      // `onload` event.
	      else
	      {
          script.onload = () => {
            this.scripts[name].loaded = true;
            resolve({script: name, loaded: true, status: 'Loaded'});
          };
	      }


        script.onerror = (error: any) => resolve({script: name, loaded: false, status: 'Loaded'});
        document.getElementsByTagName('head')[0].appendChild(script);
      }
    });
	}
}