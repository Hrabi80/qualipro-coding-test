import { Concert } from "./concert.interface";

export interface Band {
    id?: number;
    name: string;
    origin: string;
    city: string;
    founded_at:Date;
    separation_date?:Date | null;
    members: number;
    founders:string;
    about:string;
  //  concerts?: [Concert];
  }