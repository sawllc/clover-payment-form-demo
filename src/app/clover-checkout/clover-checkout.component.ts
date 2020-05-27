import { Component, OnInit } from '@angular/core';
import { ScriptService } from './shared/script.service';

declare var Clover: any;

// IMPORTANT: Do not put production keys in the code.
// Use environment variables for these values.
const cloverApiKey = "";

// Clover IFRAME Integration docs
// https://docs.clover.com/clover-platform/docs/using-the-clover-hosted-iframe

@Component({
  selector: 'app-clover-checkout',
  templateUrl: './clover-checkout.component.html',
  styleUrls: ['./clover-checkout.component.scss']
})
export class CloverCheckoutComponent implements OnInit {

	private CloverClient = false;

  constructor(private ScriptSrvc: ScriptService) {
  	console.log("clover-checkout-component instantiated.");
  }

  ngOnInit(): void {
  	let $self: CloverCheckoutComponent = this;
		$self.ScriptSrvc.load('clover').then(data => {
      if(cloverApiKey) {
        $self.CloverClient = new Clover(cloverApiKey);
        console.log("Clover SDK Dynamically Loaded.");
        console.log("You may now interact with the Clover JS SDK Client.");
        // $self.CloverClient.elements()
      } 
      else {
        console.error("Clover SDK Dynamically Loaded, but there was not a defined API Key to instantiate the Clover JS SDK Client.");
      }
		}).catch(error => console.log(error));
  }
}
